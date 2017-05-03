<?php

namespace MagicWordBundle\Manager\Letter;

use JMS\DiExtraBundle\Annotation as DI;
use Innova\LexiconBundle\Entity\Language;
use MagicWordBundle\Entity\Bigram\Grille;

/**
 * @DI\Service("mw_manager.bigram")
 */
class BigramManager
{

    protected $fileLocator;

    /**
     * @DI\InjectParams({
     *      "fileLocator" = @DI\Inject("file_locator"),
     * })
     */
    public function __construct($fileLocator)
    {
        $this->fileLocator = $fileLocator;
    }


    public function generate()
    {
        $g1 = new Grille();
        $file = $this->fileLocator->locate('files/freq_bigrammes_dico_ABU_poids.txt');
		$g1->generGrillePonderation($file);
		$tabCases = $g1->getTabCases();

        $letters = [];
        foreach ($tabCases as $tabCase) {
            $letters[] = $tabCase->getVal();
        }

        return $letters;
    }
}
