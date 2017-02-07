<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Innova\LexiconBundle\Entity\Language;

class LetterController extends Controller
{
    /**
     * @Route("/get-letters/{id}", name="get_letters", options={"expose"=true})
     * @Method("POST")
     */
    public function getInflectionAction(Language $language)
    {
        $letters = $this->get('mw_manager.letter_language')->getWeightedLettersByLanguage($language);

        return new JsonResponse($letters);
    }
}
