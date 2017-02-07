<?php

namespace MagicWordBundle\Repository;

class WrongFormRepository extends \Doctrine\ORM\EntityRepository
{
    public function getMostCommon($language)
    {
        $em = $this->_em;

        $dql = 'SELECT w, (SELECT COUNT(a.id) FROM MagicWordBundle\Entity\Activity a WHERE w MEMBER OF a.wrongForms) AS countActivity
                FROM MagicWordBundle\Entity\WrongForm w
                WHERE w.language = :language
                ORDER BY countActivity DESC';

        $query = $em->createQuery($dql);
        $query->setParameter('language', $language);

        $results = $query->getResult();

        return $results;
    }
}
