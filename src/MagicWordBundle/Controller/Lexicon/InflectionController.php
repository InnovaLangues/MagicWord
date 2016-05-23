<?php

namespace MagicWordBundle\Controller\Lexicon;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use MagicWordBundle\Entity\Lexicon\Inflection;
use MagicWordBundle\Entity\Language;

class InflectionController extends Controller
{
    /**
     * @Route("/inflection/{id}", name="inflection", requirements={
     *     "page": "\d+"
     * })
     * @ParamConverter("inflexion", class="MagicWordBundle:Lexicon\Inflection")
     */
    public function getInfosAction(Inflection $inflection)
    {
        return $this->render('MagicWordBundle:Lexicon:inflection.html.twig', array('inflection' => $inflection));
    }

    /**
     * @Route("/inflection/check/{id}", name="check_existence", options={"expose"=true})
     * @ParamConverter("language", class="MagicWordBundle:Language")
     * @Method("POST")
     */
    public function checkExistenceAction(Language $language, Request $request)
    {
        $inflection = $request->request->get('inflection');
        $inflection = $this->get('mw_manager.inflection')->checkExistence($inflection, $language);

        return new JsonResponse($inflection);
    }
}
