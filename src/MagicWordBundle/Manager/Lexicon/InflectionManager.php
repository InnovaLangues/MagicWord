<?php

namespace MagicWordBundle\Manager\Lexicon;

use JMS\DiExtraBundle\Annotation as DI;
use Innova\LexiconBundle\Entity\Language;

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
        $inflection = $this->em->getRepository('InnovaLexiconBundle:Inflection')->getByLanguageAndContentOrCleaned($language, $inflection);

        return $inflection;
    }

    public function getCleanContent($form)
    {
        $str = mb_strtolower($form, 'UTF-8');
        $cleanContent = str_replace(
          array(
              'à', 'â', 'ä', 'á', 'ã', 'å',
              'î', 'ï', 'ì', 'í',
              'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
              'ù', 'û', 'ü', 'ú',
              'é', 'è', 'ê', 'ë',
              'ç', 'ÿ', 'ñ', 'œ',
          ),
          array(
              'a', 'a', 'a', 'a', 'a', 'a',
              'i', 'i', 'i', 'i',
              'o', 'o', 'o', 'o', 'o', 'o',
              'u', 'u', 'u', 'u',
              'e', 'e', 'e', 'e',
              'c', 'y', 'n', 'oe',
          ),
          $str
        );

        return addslashes($cleanContent);
    }
}
