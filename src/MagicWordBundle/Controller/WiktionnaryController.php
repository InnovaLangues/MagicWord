<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class WiktionnaryController extends Controller
{
    /**
     * @Route("/wiktionnary/{lemma}/{language}", name="wiktionnary", options={"expose"=true})
     * @Method("GET")
     */
    public function getWiktionnaryDefAction($lemma, $language)
    {
        $def = $this->get('innovalangues_wiktionary')->getDefinitions($lemma, $language);

        return new Response($def);
    }
}
