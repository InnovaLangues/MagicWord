<?php

namespace MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MagicWordBundle\Entity\GridPattern;
use MagicWordBundle\Form\Type\GridPatternType;

/**
 * @DI\Service("mw_manager.grid_pattern")
 */
class GridPatternManager
{
    protected $em;
    protected $tokenStorage;
    protected $formFactory;
    protected $currentUser;

    /**
     * @DI\InjectParams({
     *      "entityManager"         = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage"          = @DI\Inject("security.token_storage"),
     *      "formFactory"           = @DI\Inject("form.factory"),
     * })
     */
    public function __construct($entityManager, $tokenStorage, $formFactory)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->formFactory = $formFactory;
        $this->currentUser = $this->tokenStorage->getToken()->getUser();
    }

    public function getMine()
    {
        $patterns = $this->em->getRepository('MagicWordBundle:GridPattern')->findByAuthor($this->currentUser);

        return $patterns;
    }

    public function getAll()
    {
        $patterns = $this->em->getRepository('MagicWordBundle:GridPattern')->findAll();

        return $patterns;
    }

    public function getForm(GridPattern $gridPattern)
    {
        $form = $this->formFactory->createBuilder(GridPatternType::class, $gridPattern)->getForm()->createView();

        return $form;
    }

    public function savePatternString(GridPattern $gridPattern, Request $request)
    {
        $form = $this->formFactory->createBuilder(GridPatternType::class, $gridPattern)->getForm();

        $strings = new ArrayCollection();
        foreach ($gridPattern->getStrings() as $string) {
            $strings->add($string);
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($strings as $string) {
                if ($gridPattern->getStrings()->contains($string) === false) {
                    $this->em->remove($string);
                }
            }
            foreach ($gridPattern->getStrings() as $string) {
                $string->setGridPattern($gridPattern);
            }

            $this->em->persist($gridPattern);
            $this->em->flush();
        }

        return;
    }
}
