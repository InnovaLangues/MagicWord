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
            }

            $this->em->persist($conquer);
            $this->em->flush();
        }

        return;
    }
}
