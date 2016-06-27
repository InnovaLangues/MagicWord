<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class WiktionnaryController extends Controller
{
    /**
     * @Route("/wiktionnary/{lemma}", name="wiktionnary", options={"expose"=true})
     * @Method("GET")
     */
    public function getWiktionnaryDefAction($lemma)
    {
        $url = 'https://fr.wiktionary.org/wiki/'.$lemma;
        $lemma = file_get_contents($url);

        return new Response($lemma);
    }
}
