<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\LexiconBundle\Entity\Lemma;
use Innova\LexiconBundle\Entity\Language;

class WordboxController extends Controller
{
    /**
     * @Route("/wordbox/{id}", name ="wordbox")
     */
    public function displayWordboxAction(Language $language)
    {
        $acquisitions = $this->get('mw_manager.wordbox')->getAcquisitionsByLanguage($language);

        return $this->render('MagicWordBundle:Wordbox:index.html.twig', [
            'acquisitions' => $acquisitions,
            'language' => $language,
        ]);
    }

    /**
     * @Route("/wordbox/add/{id}", name="add-to-wordbox")
     * @ParamConverter("lemma", class="InnovaLexiconBundle:Lemma")
     */
    public function addToWordboxAction(Lemma $lemma)
    {
        $this->get('mw_manager.wordbox')->addToWordbox($lemma, 'manual');

        return $this->redirectToRoute('wordbox');
    }

    /**
     * @Route("/js/wordbox/add/{id}", name="add-to-wordbox-js", options={"expose"=true})
     * @ParamConverter("lemma", class="InnovaLexiconBundle:Lemma")
     */
    public function addToWordboxJSAction(Lemma $lemma)
    {
        $this->get('mw_manager.wordbox')->addToWordbox($lemma, 'manual');

        return new Response();
    }
}
