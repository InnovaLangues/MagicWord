<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Grid;
use MagicWordBundle\Entity\Language;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.grid")
 */
class GridManager
{
    protected $em;
    protected $letterLangManager;
    protected $squareManager;
    protected $foundableFormManager;
    protected $tokenStorage;
    protected $currentUser;
    protected $currentLanguage;

    /**
     * @DI\InjectParams({
     *      "entityManager"         = @DI\Inject("doctrine.orm.entity_manager"),
     *      "letterLangManager"     = @DI\Inject("mw_manager.letter_language"),
     *      "foundableFormManager"  = @DI\Inject("mw_manager.foundableForm"),
     *      "squareManager"         = @DI\Inject("mw_manager.square"),
     *      "tokenStorage"          = @DI\Inject("security.token_storage"),
     * })
     */
    public function __construct($entityManager, $letterLangManager, $foundableFormManager, $squareManager, $tokenStorage)
    {
        $this->em = $entityManager;
        $this->letterLangManager = $letterLangManager;
        $this->foundableFormManager = $foundableFormManager;
        $this->squareManager = $squareManager;
        $this->tokenStorage = $tokenStorage;
        $this->currentUser = $this->tokenStorage->getToken()->getUser();
    }

    private function newGrid($language)
    {
        $grid = new Grid();
        $grid->setLanguage($language);

        return $grid;
    }

    public function seekOrGenerateForTraining()
    {
        $language = $this->currentUser->getLanguage();
        $grid = ($existingGrid = $this->em->getRepository('MagicWordBundle:Grid')->findNotPlayedForTraining($this->currentUser))
            ? $existingGrid
            : $this->generate($language);

        return $grid;
    }

    public function generate(Language $language)
    {
        $grid = $this->newGrid($language);
        $letters = $this->letterLangManager->getWeightedLettersByLanguage($language);
        foreach ($letters as $letter) {
            $grid->addSquare($this->squareManager->create($letter, $grid));
        }

        $words = $this->findInflections($grid);
        $grid = $this->saveInflections($grid);

        return $grid;
    }

    public function createGrid($request, $save)
    {
        $languageId = $request->request->get('language');
        $language = $this->em->getRepository('MagicWordBundle:Language')->find($languageId);

        $grid = $this->newGrid($language);

        $this->addSquares($grid, $request->request->get('squares'));

        if ($save) {
            $grid = $this->saveInflections($grid);
        }

        return $grid;
    }

    public function updateGrid(Grid $grid, Request $request)
    {
        $this->removeSquare($grid);
        $this->removeFoundables($grid);

        $this->em->refresh($grid);

        $this->addSquares($grid, $request->request->get('squares'));
        $grid = $this->saveInflections($grid);

        $this->em->persist($grid);
        $this->em->flush($grid);

        return $grid;
    }

    public function saveInflections(Grid $grid)
    {
        $inflections = $this->findInflections($grid);
        $this->foundableFormManager->populateFoundables($inflections, $grid);

        $this->em->persist($grid);
        $this->em->flush();

        return $grid;
    }

    private function removeSquare(Grid $grid)
    {
        $squares = $grid->getSquares();
        foreach ($squares as $square) {
            $this->em->remove($square);
        }

        $this->em->flush();
    }

    private function removeFoundables(Grid $grid)
    {
        $foundables = $grid->getFoundableForms();
        foreach ($foundables as $foundable) {
            $this->em->remove($foundable);
        }

        $this->em->flush();
    }

    private function addSquares(Grid $grid, $letters)
    {
        foreach ($letters as $letter) {
            $grid->addSquare($this->squareManager->create(strtolower($letter), $grid));
        }

        return $grid;
    }

    public function getInflections($request)
    {
        $grid = $this->createGrid($request, false);
        $inflections = $this->findInflections($grid);

        return $inflections;
    }

    public function getFoundableForms(Request $request)
    {
        $grid = $this->createGrid($request, false);
        $inflections = $this->findInflections($grid);

        $this->foundableFormManager->populateFoundables($inflections, $grid);

        return $grid->getFoundableForms();
    }

    public function getCombos($request)
    {
        $inflections = $this->getInflections($request);
        $combos = [];
        foreach ($inflections as $inflection) {
            $lemma = $inflection->getLemma();
            $form = $inflection->getCleanedContent();
            $lemmaId = $lemma->getId();

            if (!isset($combos[$lemmaId])) {
                $combos[$lemmaId] = ['lemma' => $lemma, 'inflections' => []];
            }

            if (!in_array($form, $combos[$lemmaId]['inflections'])) {
                $combos[$lemmaId]['inflections'][] = $form;
            }
        }

        $combos = array_filter($combos, function ($v) {return count($v['inflections']) > 1;});

        usort($combos, function ($a, $b) {
            return count($b['inflections']) - count($a['inflections']);
        });

        return $combos;
    }

    public function findInflections(Grid $grid)
    {
        $i = 0;
        $simplifiedGrid = array();
        $words = array();
        $this->currentLanguage = $grid->getLanguage();

        for ($y = 0; $y < 4; ++$y) {
            for ($x = 0; $x < 4; ++$x) {
                if ($grid->getSquares()[$i]) {
                    $simplifiedGrid[$y][$x] = $grid->getSquares()[$i]->getLetter()->getValue();
                } else {
                    $simplifiedGrid[$y][$x] = '_';
                }
                ++$i;
            }
        }

        // on l'alimente par récursivité avec la méthode nextLetter() en partant de chaque lettre
        for ($y = 0; $y < 4; ++$y) {
            for ($x = 0; $x < 4; ++$x) {
                // ajout au tableau des mots potentiels de ceux qui commencent par la lettre en x, y
                $words = array_unique(array_merge($words, $this->nextLetter('', $simplifiedGrid, $x, $y)), SORT_STRING);
            }
        }

        // words contient tous les débuts de mots ayant été trouvé dans le dictionnaire
        // il faut vérifier si chaque word existe réellement dans le dictionnaire
        if ($words) {
            $inflections = $this->em->getRepository("MagicWordBundle:Lexicon\Inflection")->getExistingWords($words, $this->currentLanguage);
        }

        return $inflections;
    }

    private function nextLetter($word, $grid, $x, $y)
    {
        // ajouter la lettre en x, y au mot courant
        $word .= $grid[$y][$x];
        // la détruire dans la grille
        $grid[$y][$x] = '_';
        // vérifier en bdd s'il existe des mots qui commencent par $word à partir de 2 lettres
        if (strlen($word) > 1) {
            $startExists = $this->em->getRepository("MagicWordBundle:Lexicon\InflectionStart")->search($word, $this->currentLanguage->getId());
            // si pas de mot dans le dico commençant par le mot en cours, ne pas retourner le mot et arrêter la recherche
            if (!$startExists) {
                return array();
            }
        }
        // stocker le début de mot dès qu'il atteint 2 lettres
        $words = strlen($word) > 1 ? array($word) : array();

        //
        // On calcule la position de la lettre suivante (autour de la lettre en cours)
        //

        // ligne du haut
        $yy = $y - 1;
        if ($yy >= 0) {
            $xx = $x - 1;
            // on vérifie que la lettre n'a pas été utilisée (donc détruite)
            if (($xx >= 0) && ($grid[$yy][$xx] != '_')) {
                // appel en récursif pour ajout d'une nouvelle lettre au mot
                $words = array_merge($words, $this->nextLetter($word, $grid, $xx, $yy));
            }

            $xx = $x;
            if ($grid[$yy][$xx] != '_') {
                $words = array_merge($words, $this->nextLetter($word, $grid, $xx, $yy));
            }

            $xx = $x + 1;
            if (($xx < 4) && ($grid[$yy][$xx] != '_')) {
                $words = array_merge($words, $this->nextLetter($word, $grid, $xx, $yy));
            }
        }

        // ligne du milieu
        $yy = $y;
        $xx = $x - 1;
        if (($xx >= 0) && ($grid[$yy][$xx] != '_')) {
            $words = array_merge($words, $this->nextLetter($word, $grid, $xx, $yy));
        }
        $xx = $x + 1;
        if (($xx < 4) && ($grid[$yy][$xx] != '_')) {
            $words = array_merge($words, $this->nextLetter($word, $grid, $xx, $yy));
        }

        // ligne du bas
        $yy = $y + 1;
        if ($yy < 4) {
            $xx = $x - 1;
            if (($xx >= 0) && ($grid[$yy][$xx] != '_')) {
                $words = array_merge($words, $this->nextLetter($word, $grid, $xx, $yy));
            }

            $xx = $x;
            if ($grid[$yy][$xx] != '_') {
                $words = array_merge($words, $this->nextLetter($word, $grid, $xx, $yy));
            }

            $xx = $x + 1;
            if (($xx < 4) && ($grid[$yy][$xx] != '_')) {
                $words = array_merge($words, $this->nextLetter($word, $grid, $xx, $yy));
            }
        }

        // renvoyer les débuts de mot trouvés
        return $words;
    }
}
