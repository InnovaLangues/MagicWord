<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Lexicon\Lemma as Lemma;

class WordboxController extends Controller
{
    /**
     * @Route("/wordbox", name ="wordbox")
     */
    public function displayWordboxAction()
    {
        $wordbox = $this->get('mw_manager.wordbox')->getWordbox();

        return $this->render('MagicWordBundle:Wordbox:index.html.twig', ['wordbox' => $wordbox]);
    }

    /**
     * @Route("/wordbox/add/{id}", name="add-to-wordbox")
     * @ParamConverter("lemma", class="MagicWordBundle:Lexicon\Lemma")
     */
    public function addToWordboxAction(Lemma $lemma)
    {
        $this->get('mw_manager.wordbox')->addToWordbox($lemma, 'manual');

        return $this->redirectToRoute('wordbox');
    }

    /**
     * @Route("/js/wordbox/add/{id}", name="add-to-wordbox-js", options={"expose"=true})
     * @ParamConverter("lemma", class="MagicWordBundle:Lexicon\Lemma")
     */
    public function addToWordboxJSAction(Lemma $lemma)
    {
        $this->get('mw_manager.wordbox')->addToWordbox($lemma, 'manual');

        return new Response();
    }
}
