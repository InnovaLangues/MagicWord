<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Rules\WordLengthPoints;
use MagicWordBundle\Entity\Letter\LetterLanguage;
use MagicWordBundle\Form\Type\WordLengthPointsType;
use Symfony\Component\HttpFoundation\Request;
use MagicWordBundle\Form\Type\LetterLanguagePointsType;

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
}
