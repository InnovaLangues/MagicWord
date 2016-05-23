<?php

namespace MagicWordBundle\Manager\Lexicon;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Language;

/**
 * @DI\Service("mw_manager.inflection")
 */
class InflectionManager
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

    public function checkExistence($inflection, Language $language)
    {
        $inflection = $this->em->getRepository("MagicWordBundle:Lexicon\Inflection")->getByLanguageAndContentOrCleaned($language, $inflection);

        return $inflection;
    }
}
