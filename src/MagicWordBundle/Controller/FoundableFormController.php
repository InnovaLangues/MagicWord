<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\LexiconBundle\Entity\Lemma;
use Innova\LexiconBundle\Entity\Language;
use MagicWordBundle\Entity\FoundableForm;

class FoundableFormController extends Controller
{
    /**
     * @Route("/found/{id}", name="found")
     */
    public function displayFoundAction(Language $language)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $found = $this->getDoctrine()->getRepository('MagicWordBundle:FoundableForm')->foundByUserAndLanguage($user, $language);
        $foundable = $this->getDoctrine()->getRepository('MagicWordBundle:FoundableForm')->foundableByLanguage($language);

        return $this->render('MagicWordBundle:FoundableForm:found.html.twig', [
            'found' => $found,
            'language' => $language,
            'foundable' => $foundable
        ]);
    }

    /**
     * @Route("/form/{formId}/{languageId}", name="form_details")
     * @ParamConverter("foundableForm", class="MagicWordBundle:FoundableForm",  options={"id" = "formId"})
     * @ParamConverter("language", class="InnovaLexiconBundle:Language", options={"id" = "languageId"})
     */
    public function displayFormDetailsAction(FoundableForm $foundableForm, Language $language)
    {
        return $this->render('MagicWordBundle:FoundableForm:details.html.twig',[
            'foundableForm' => $foundableForm,
            'language' => $language
        ]);
    }
}
