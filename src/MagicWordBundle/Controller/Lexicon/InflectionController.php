<?php

namespace MagicWordBundle\Controller\Lexicon;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Lexicon\Inflection;

class InflectionController extends Controller
{
    /**
     * @Route("/inflection/{id}", name="inflection")
     * @ParamConverter("inflexion", class="MagicWordBundle:Lexicon\Inflection")
     */
    public function getInfosAction(Inflection $inflection)
    {
        return $this->render('MagicWordBundle:Lexicon:inflection.html.twig', array('inflection' => $inflection));
    }
}
