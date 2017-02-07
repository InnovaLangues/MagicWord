<?php

namespace MagicWordBundle\Controller\Lexicon;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\LexiconBundle\Entity\Lemma;

class LemmaController extends Controller
{
    /**
     * @Route("/lemma/{id}", name="lemma")
     * @ParamConverter("lemma", class="InnovaLexiconBundle:Lemma")
     */
    public function getInfosAction(Lemma $lemma)
    {
        return $this->render('MagicWordBundle:Lexicon:lemma.html.twig', array('lemma' => $lemma));
    }
}
