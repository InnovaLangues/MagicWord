<?php

namespace  MagicWordBundle\Manager\Letter;

use JMS\DiExtraBundle\Annotation as DI;
use Innova\LexiconBundle\Entity\Language;

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

    public function getCustomWeigth($customLetters)
    {
        $letters = '';
        foreach ($customLetters as $letter => $count) {
            $letters = $this->repeatLetter($letters, $letter, $count);
        }

        return $this->lottery($letters, 16);
    }

    public function getWeightedLettersByLanguage(Language $language)
    {
        $lettersLanguage = $this->em->getRepository("MagicWordBundle:Letter\LetterLanguage")->findByLanguage($language);
        $letters = '';
        foreach ($lettersLanguage as $letterLanguage) {
            $letters = $this->repeatLetter($letters, $letterLanguage->getLetter()->getValue(), $letterLanguage->getWeight());
        }

        return $this->lottery($letters, 16);
    }

    private function repeatLetter($str, $letter, $count)
    {
        $str .= str_repeat($letter, $count);

        return $str;
    }

    private function lottery($str, $count)
    {
        $letters = substr(str_shuffle($str), 0, $count);

        return str_split($letters);
    }
}
