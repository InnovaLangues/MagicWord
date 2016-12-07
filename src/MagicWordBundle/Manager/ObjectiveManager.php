<?php

namespace MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Collections\ArrayCollection;
use MagicWordBundle\Entity\RoundType\Conquer;
use MagicWordBundle\Form\Type\RoundType;
use MagicWordBundle\Entity\Grid;
use MagicWordBundle\Entity\ObjectiveType\Combo;
use MagicWordBundle\Entity\ObjectiveType\FindWord;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.objective")
 */
class ObjectiveManager
{
    protected $em;
    protected $formFactory;
    protected $gridManager;
    protected $wiktionary;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "formFactory"   = @DI\Inject("form.factory"),
     *      "gridManager"   = @DI\Inject("mw_manager.grid"),
     *      "wiktionary" =  @DI\Inject("innovalangues_wiktionary"),
     * })
     */
    public function __construct($entityManager, $formFactory, $gridManager, $wiktionary)
    {
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
        $this->gridManager = $gridManager;
        $this->wiktionary = $wiktionary;
    }

    public function saveObjectives(Conquer $conquer, Request $request)
    {
        $form = $this->formFactory->createBuilder(RoundType::class, $conquer)->getForm();

        // retrieve former objectives
        $formerObjectives = new ArrayCollection();
        foreach ($conquer->getObjectives() as $objective) {
            $formerObjectives->add($objective);
        }

        $form->handleRequest($request);
        if ($form->isValid()) {
            // remove unused objectives
            foreach ($formerObjectives as $formerObjective) {
                if ($conquer->getObjectives()->contains($formerObjective) === false) {
                    $this->em->remove($formerObjective);
                }
            }
            //link objectives to conquer
            foreach ($conquer->getObjectives() as $objective) {
                $objective->setConquer($conquer);
                if ($objective->getDiscr() == 'findword') {
                    $this->handleFindWord($objective);
                }
            }

            $this->em->persist($conquer);
            $this->em->flush();
        }

        return;
    }

    public function generateObjective(Conquer $conquer)
    {
        $objectiveTypes = ['findword', 'combo'];
        $key = array_rand($objectiveTypes);
        $objectiveType = $objectiveTypes[$key];

        switch ($objectiveType) {
            case 'findword':
                $conquer = $this->addFindWord($conquer);
                break;

            case 'combo':
                $conquer = $this->addCombo($conquer);
                break;
        }

        $this->em->persist($conquer);
        $this->em->flush();

        return $conquer;
    }

    private function handleFindWord($objective)
    {
        $repo = $this->em->getRepository("MagicWordBundle:Lexicon\Lemma");
        $objective->getLemmas()->clear();

        if ($objective->getLemmaEnough()) {
            $lemmas = $repo->getByContentAndLanguage($objective);
            $objective->addLemmas($lemmas);
        }
    }

    private function addCombo($conquer)
    {
        $number = rand(1, 3);
        $length = rand(2, 3);
        $this->generateCombo($number, $length, $conquer);

        $this->em->flush();

        return $conquer;
    }

    private function addFindWord($conquer)
    {
        $grid = $conquer->getGrid();
        $inflections = $this->gridManager->retrieveInflections($grid);
        shuffle($inflections);
        $language = mb_substr($grid->getLanguage()->getName(), 0, 2);
        $limit = rand(1, 3);
        $found = 0;

        foreach ($inflections as $inflection) {
            $form = $inflection->getCleanedContent();
            if (strlen($form) > 2) {
                if ($hint = $this->wiktionary->getRandomDefinition($form, $language)) {
                    $this->generateFindWord(false, $form, $hint, $conquer);
                    ++$found;
                    if ($found == $limit) {
                        break;
                    }
                }
            }
        }

        $this->em->flush();

        return $conquer;
    }

    private function generateFindWord($lemmaEnough, $form, $hint, $conquer)
    {
        $findWord = new FindWord();
        $findWord->setLemmaEnough($lemmaEnough);
        $findWord->setHint($hint);
        $findWord->setInflection($form);
        $findWord->setConquer($conquer);
        $this->em->persist($findWord);

        return $findWord;
    }

    private function generateCombo($number, $length, $conquer)
    {
        $combo = new Combo();
        $combo->setNumber($number);
        $combo->setLenght($length);
        $combo->setConquer($conquer);

        $this->em->persist($combo);

        return $conquer;
    }

    public function isValid($objective)
    {
        $errors = [];

        $foundableRepo = $this->em->getRepository('MagicWordBundle:FoundableForm');
        $conquer = $objective->getConquer();
        $grid = $conquer->getGrid();
        $roundName = $conquer->getDisplayOrder() + 1;

        if ($grid) {
            switch ($objective->getDiscr()) {
                case 'findword':
                    if (!$foundableRepo->findOneBy(['grid' => $grid, 'form' => $objective->getinflection()])) {
                        $errors[] = 'problème findword non réalisable round '.$roundName;
                    }
                    break;
                case 'constraint':
                    $foundables = $foundableRepo->getByGridAndCriteria($grid, $objective);
                    if (count($foundables) < $objective->getNumberToFind()) {
                        $errors[] = 'problème constraint non réalisable round '.$roundName;
                    }
                default:
                    break;
                }
        }

        return $errors;
    }
}
