<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\LexiconBundle\Entity\Lemma;
use Innova\LexiconBundle\Entity\Language;

class FoundedController extends Controller
{
    /**
     * @Route("/founded/{id}", name ="founded")
     */
    public function displayWordboxAction(Language $language)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $found = $this->getDoctrine()->getRepository('MagicWordBundle:FoundableForm')->foundByUserAndLanguage($user, $language);

        return $this->render('MagicWordBundle:Found:index.html.twig', [
            'found' => $found,
            'language' => $language,
        ]);
    }
}
