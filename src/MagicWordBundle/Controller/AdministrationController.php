<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use MagicWordBundle\Entity\Rules\WordLengthPoints;
use MagicWordBundle\Entity\Letter\LetterLanguage;
use Symfony\Component\HttpFoundation\Request;

class AdministrationController extends Controller
{
    /**
     * @Route("/administration/index", name="admin_index")
     */
    public function indexAction()
    {
        return $this->render('MagicWordBundle:Administration:index.html.twig');
    }

    /**
     * @Route("/administration/wordlengthpoints", name="wordlengthpoints")
     */
    public function wordLengthPointsAction()
    {
        $wordlengthpoints = $this->getDoctrine()->getRepository('MagicWordBundle:Rules\WordLengthPoints')->findAll();

        return $this->render('MagicWordBundle:Administration:wordlengthpoints.html.twig', ['wordlengthpoints' => $wordlengthpoints]);
    }

    /**
     * @Route("/administration/wordlengthpoints/{id}", name="wordlengthpoint_edit")
     * @Method("GET")
     */
    public function wordLengthPointEditAction(WordLengthPoints $wordlengthpoint)
    {
        $form = $this->get('mw_manager.administration')->getWordLengthPointForm($wordlengthpoint);

        return $this->render('MagicWordBundle:Administration:wordlengthpoint-edit.html.twig', ['form' => $form, 'wordlengthpoint' => $wordlengthpoint]);
    }

    /**
     * @Route("/administration/wordlengthpoints/{id}", name="wordlengthpoint_submit")
     * @Method("POST")
     */
    public function wordLengthPointSubmitAction(WordLengthPoints $wordlengthpoint, Request $request)
    {
        $this->get('mw_manager.administration')->handleWordLengthPointForm($wordlengthpoint, $request);

        return $this->redirectToRoute('wordlengthpoints');
    }

    /**
     * @Route("/administration/letterslanguage", name="letterslanguage")
     */
    public function languageLetterPointsAction()
    {
        $letterslanguage = $this->getDoctrine()->getRepository('MagicWordBundle:Letter\LetterLanguage')->findAll();

        return $this->render('MagicWordBundle:Administration:letterslanguage.html.twig', ['letterslanguage' => $letterslanguage]);
    }

    /**
     * @Route("/administration/letterlanguage/{id}", name="letterlanguage_edit")
     * @Method("GET")
     */
    public function languageLetterPointsEditAction(LetterLanguage $letterlanguage)
    {
        $form = $this->get('mw_manager.administration')->getLetterLanguageForm($letterlanguage);

        return $this->render('MagicWordBundle:Administration:letterslanguage-edit.html.twig', ['letterlanguage' => $letterlanguage, 'form' => $form]);
    }

    /**
     * @Route("/administration/letterlanguage/{id}", name="letterlanguage_submit")
     * @Method("POST")
     */
    public function languageLetterPointsSubmitAction(LetterLanguage $letterlanguage, Request $request)
    {
        $this->get('mw_manager.administration')->handleLetterLanguageForm($letterlanguage, $request);

        return $this->redirectToRoute('letterslanguage');
    }
}
