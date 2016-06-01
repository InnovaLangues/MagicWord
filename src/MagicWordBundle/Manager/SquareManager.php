<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Square;

/**
 * @DI\Service("mw_manager.square")
 */
class SquareManager
{
    protected $em;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     * })
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function create($letter, $grid)
    {
        $letter = $this->em->getRepository("MagicWordBundle:Letter\CanonicLetter")->findOneByValue($letter);

        $square = new Square();
        $square->setPosition(0);
        $square->setLetter($letter);
        $square->setGrid($grid);
        $this->em->persist($square);
        $this->em->persist($grid);
        $this->em->flush();

        return $square;
    }
}
