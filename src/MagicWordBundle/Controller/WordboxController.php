<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Lexicon\Lemma as Lemma;

class WordboxController extends Controller
{
    /**
     * @Route("/wordbox")
     */
    public function displayWordboxAction()
    {
        return $this->render('MagicWordBundle:Wordbox:index.html.twig');
    }

    /**
     * @Route("/wordbox/add/{id}")
     * @ParamConverter("lemma", class="MagicWordBundle:Lexicon\Lemma")
     */
    public function addToWordboxAction(Lemma $lemma)
    {
        return $this->render('MagicWordBundle:Default:index.html.twig');
    }
}
