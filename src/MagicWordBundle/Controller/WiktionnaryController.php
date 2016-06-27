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
        $url = 'https://'.$language.'.wiktionary.org/wiki/'.$lemma;
        //$lemma = file_get_contents($url);

        $handle = @fopen($url, 'r');
        if ($handle) {
            while (!feof($handle)) {
                $def = stream_get_contents($handle);
            }
            fclose($handle);
        } else {
            $def = 'Oups...';
        }

        return new Response($def);
    }
}
