<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Rules\WordLengthPoints;
use MagicWordBundle\Entity\Letter\LetterLanguage;
use MagicWordBundle\Form\Type\WordLengthPointsType;
use Symfony\Component\HttpFoundation\Request;
use MagicWordBundle\Form\Type\LetterLanguagePointsType;
use MagicWordBundle\Form\Type\GeneralParametersType;
use MagicWordBundle\Entity\GeneralParameters;

/**
 * @DI\Service("mw_manager.administration")
 */
class AdministrationManager
{
    protected $em;
    protected $formFactory;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "formFactory"   = @DI\Inject("form.factory"),
     * })
     */
    public function __construct($entityManager, $formFactory)
    {
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function getWordLengthPointForm(WordLengthPoints $wordLengthPoints)
    {
        $form = $this->formFactory->createBuilder(WordLengthPointsType::class, $wordLengthPoints)->getForm()->createView();

        return $form;
    }

    public function handleWordLengthPointForm(WordLengthPoints $wordlengthpoint, Request $request)
    {
        $form = $this->formFactory->createBuilder(WordLengthPointsType::class, $wordlengthpoint)->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($wordlengthpoint);
            $this->em->flush();
        }

        return;
    }

    public function getLetterLanguageForm(LetterLanguage $letterlanguage)
    {
        $form = $this->formFactory->createBuilder(LetterLanguagePointsType::class, $letterlanguage)->getForm()->createView();

        return $form;
    }

    public function handleLetterLanguageForm(LetterLanguage $letterlanguage, Request $request)
    {
        $form = $this->formFactory->createBuilder(LetterLanguagePointsType::class, $letterlanguage)->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($letterlanguage);
            $this->em->flush();
        }

        return;
    }

    public function getGeneralParametersForm()
    {
        $generalParameters = $this->getGeneralParameters();

        if (!$generalParameters) {
            $generalParameters = new GeneralParameters();
            $generalParameters->setHomeText("lorem ipsum...");
            $generalParameters->setSelfRegistration(true);
            $this->em->persist($generalParameters);
            $this->em->flush();
        }

        $form = $this->formFactory->createBuilder(GeneralParametersType::class, $generalParameters)->getForm()->createView();

        return $form;

    }

    public function handleGeneralParametersForm(Request $request){
        $generalParameters = $this->getGeneralParameters();

        $form = $this->formFactory->createBuilder(GeneralParametersType::class, $generalParameters)->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($generalParameters);
            $this->em->flush();
        }

        return;
    }

    public function getGeneralParameters()
    {
        $generalParameters = $this->em->getRepository("MagicWordBundle:GeneralParameters")->get();

        return $generalParameters;

    }
}
