<?php

namespace  MagicWordBundle\Manager\Letter;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Language;

/**
 * @DI\Service("mw_manager.letter_language")
 */
class LetterLanguageManager
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

    public function getWeightedLettersByLanguage(Language $language)
    {
        $lettersLanguage = $this->em->getRepository("MagicWordBundle:Letter\LetterLanguage")->findByLanguage($language);
        $letters = '';
        foreach ($lettersLanguage as $letterLanguage) {
            $letters .= str_repeat($letterLanguage->getLetter()->getValue(), $letterLanguage->getWeight());
        }
        $letters = substr(str_shuffle($letters), 0, 16);

        return str_split($letters);
    }
}
