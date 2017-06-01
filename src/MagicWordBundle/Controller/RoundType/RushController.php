<?php

namespace MagicWordBundle\Controller\RoundType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\RoundType\Rush;

class RushController extends Controller
{
    /**
     * @Route("/rush/{id}", name="rush")
     * @ParamConverter("rush", class="MagicWordBundle:RoundType\Rush")
     */
    public function displayRushAction(Rush $rush)
    {
        return $this->render('MagicWordBundle:Round/Rush:edit.html.twig', ['rush' => $rush]);
    }

    /**
     * @Route("/rush/{id}/save-grid", name="rush_save_grid" , options={"expose"=true})
     * @ParamConverter("rush", class="MagicWordBundle:RoundType\Rush")
     */
    public function saveConquerGridAction(Rush $rush, Request $request)
    {
        $this->get('mw_manager.round')->saveRushGrid($rush, $request);
        $foundableForms = $rush->getGrid()->getFoundableForms();
        $template = $this->get('templating')->render('MagicWordBundle:Grid:possible-inflections.html.twig', ['foundableForms' => $foundableForms,  'btn' => false ]);

        $response = [
            'foundables' => $template,
            'gridLanguage' => $rush->getGrid()->getLanguage()->getId(),
        ];

        return new JsonResponse($response);
    }
}
