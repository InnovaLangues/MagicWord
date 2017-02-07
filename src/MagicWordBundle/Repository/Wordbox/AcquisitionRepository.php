<?php

namespace MagicWordBundle\Repository\Wordbox;

use MagicWordBundle\Entity\Wordbox;
use Innova\LexiconBundle\Entity\Language;

class AcquisitionRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOneByWordboxAndLanguage(Wordbox $wordbox, Language $language)
    {
        $em = $this->_em;
        $dql = "SELECT acquisition FROM MagicWordBundle\Entity\Wordbox\Acquisition acquisition
                LEFT JOIN acquisition.lemma lemma
                WHERE lemma.language = :language
                AND acquisition.wordbox = :wordbox
                ORDER BY lemma.content ASC
                ";

        $query = $em->createQuery($dql);
        $query->setParameter('wordbox', $wordbox)
              ->setParameter('language', $language);

        return $query->getResult();
    }
}
