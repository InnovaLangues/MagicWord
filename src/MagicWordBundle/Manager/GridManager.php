<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Grid;
use MagicWordBundle\Entity\Language;

/**
 * @DI\Service("mw_manager.grid")
 */
class GridManager
{
    protected $em;
    protected $letterLangManager;
    protected $squareManager;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "letterLangManager" = @DI\Inject("mw_manager.letter_language"),
     *      "squareManager" = @DI\Inject("mw_manager.square"),
     * })
     */
    public function __construct($entityManager, $letterLangManager, $squareManager)
    {
        $this->em = $entityManager;
        $this->letterLangManager = $letterLangManager;
        $this->squareManager = $squareManager;
    }

    public function generate(Language $language)
    {
        $grid = new Grid();
        $letters = $this->letterLangManager->getWeightedLettersByLanguage($language);
        foreach ($letters as $letter) {
            $grid->addSquare($this->squareManager->create($letter, $grid));
        }

        $words = $this->findInflections($grid);
        $grid = $this->saveInflections($grid);

        return $grid;
    }

    public function saveinflections(Grid $grid)
    {
        $inflections = $this->findInflections($grid);

        $grid->addInflections($inflections);

        $this->em->persist($grid);
        $this->em->flush();

        return $grid;
    }

    public function findInflections(Grid $grid)
    {
        $i = 0;
        $simplifiedGrid = array();
        $words = array();

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
                $words = array_merge($words, $this->nextLetter('', $simplifiedGrid, $x, $y));
            }
        }

        // words contient tous les débuts de mots ayant été trouvé dans le dictionnaire
        // il faut vérifier si chaque word existe réellement dans le dictionnaire
        if ($words) {
            $words = $this->em->getRepository("MagicWordBundle:Lexicon\Inflection")->getExistingWords($words);
        }

        return $words;
    }

    private function nextLetter($word, $grid, $x, $y)
    {
        // ajouter la lettre en x, y au mot courant
        $word .= $grid[$y][$x];

        // la détruire dans la grille
        $grid[$y][$x] = '_';

        // vérifier en bdd s'il existe des mots qui commencent par $word à partir de 2 lettres
        if (strlen($word) > 1) {
            $words = $this->em->getRepository("MagicWordBundle:Lexicon\Inflection")->getByStartingBySubstring($word);

            // si pas de mot dans le dico commençant par le mot en cours, ne pas retourner le mot et arrêter la recherche
            if (!$words) {
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
