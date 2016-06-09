<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Activity;
use MagicWordBundle\Entity\FoundForm;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.foundform")
 */
class FoundFormManager
{
    protected $em;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     * })
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function create(Activity $activity, Request $request)
    {
        $form = new FoundForm();
        $form->setActivity($activity);
        $form->setPoints($request->request->get('points'));
        $form->setForm($request->request->get('form'));

        foreach ($request->request->get('inflectionIds') as $inflectionId) {
            $inflection = $this->em->getRepository('MagicWordBundle:Lexicon\Inflection')->find($inflectionId);
            $form->addInflection($inflection);
        }

        $this->em->persist($form);
        $this->em->flush();

        return $form;
    }
}
