<?php

namespace MagicWordBundle\Repository\Lexicon;

class LemmaRepository extends \Doctrine\ORM\EntityRepository
{
    public function getByContentAndLanguage($findWord)
    {
        $em = $this->_em;

        $dql = 'SELECT l FROM MagicWordBundle\Entity\Lexicon\Lemma l
                WHERE EXISTS(
                    SELECT i FROM MagicWordBundle\Entity\Lexicon\Inflection i
                    WHERE i.lemma = l
                    AND i.cleanedContent = :cleanedContent
                    AND i.language = :language
                )';

        $query = $em->createQuery($dql);
        $query->setParameter('cleanedContent', $findWord->getInflection());
        $query->setParameter('language', $findWord->getConquer()->getLanguage());

        return $query->getResult();
    }
}
