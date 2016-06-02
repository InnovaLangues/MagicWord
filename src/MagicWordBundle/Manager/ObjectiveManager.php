<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Collections\ArrayCollection;
use MagicWordBundle\Entity\RoundType\Conquer;
use MagicWordBundle\Form\Type\RoundType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.objective")
 */
class ObjectiveManager
{
    protected $em;
    protected $formFactory;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "formFactory"   = @DI\Inject("form.factory"),
     * })
     */
    public function __construct($entityManager, $formFactory)
    {
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function saveObjectives(Conquer $conquer, Request $request)
    {
        $form = $this->formFactory->createBuilder(RoundType::class, $conquer)->getForm();

        // retrieve former combos
        $formerCombos = new ArrayCollection();
        foreach ($conquer->getCombos() as $combo) {
            $formerCombos->add($combo);
        }

        // retrieve former findword
        $formerFindWords = new ArrayCollection();
        foreach ($conquer->getFindWords() as $findWord) {
            $formerFindWords->add($findWord);
        }

        $form->handleRequest($request);
        if ($form->isValid()) {
            // remove unused combos
            foreach ($formerCombos as $combo) {
                if ($conquer->getCombos()->contains($combo) === false) {
                    $this->em->remove($combo);
                }
            }

            // remove unused objectives
            foreach ($formerFindWords as $findWord) {
                if ($conquer->getFindWords()->contains($findWord) === false) {
                    $this->em->remove($findWord);
                }
            }

            //link new ones to conquer
            foreach ($conquer->getCombos() as $combo) {
                $combo->setRound($conquer);
            }

            //link new ones to conquer
            foreach ($conquer->getFindWords() as $findWord) {
                $findWord->setRound($conquer);
            }

            $this->em->persist($conquer);
            $this->em->flush();
        }

        return;
    }
}
