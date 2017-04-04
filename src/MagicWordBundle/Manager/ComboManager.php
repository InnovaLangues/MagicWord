<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Rules\ComboPoints;
use MagicWordBundle\Entity\CombosDone;
use MagicWordBundle\Entity\Activity;

/**
 * @DI\Service("mw_manager.combo")
 */
class ComboManager
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

    public function create(ComboPoints $comboPoints, Activity $activity)
    {
        $comboDone = new CombosDone();
        $comboDone->setActivity($activity);
        $comboDone->setComboType($comboPoints);

        $this->em->persist($comboDone);

        return $comboDone;
    }

    public function increment(CombosDone $comboDone)
    {
        $total = $comboDone->getTotal();
        $comboDone->setTotal($total + 1);

        $this->em->persist($comboDone);

        return $comboDone;
    }
}
