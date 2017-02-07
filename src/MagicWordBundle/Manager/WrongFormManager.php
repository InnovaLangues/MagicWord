<?php

namespace MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use Innova\LexiconBundle\Entity\Language;
use MagicWordBundle\Entity\WrongForm;

/**
 * @DI\Service("mw_manager.wrongform")
 */
class WrongFormManager
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

    public function create($form, Language $language)
    {
        $wrongForm = new WrongForm();
        $wrongForm->setLanguage($language);
        $wrongForm->setForm($form);

        $this->em->persist($wrongForm);
        $this->em->flush();

        return $wrongForm;
    }
}
