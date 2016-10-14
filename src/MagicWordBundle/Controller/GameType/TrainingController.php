<?php

namespace MagicWordBundle\Controller\GameType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Language;

class TrainingController extends Controller
{
    /**
     * @Route("/train/{id}", name="train")
     * @ParamConverter("language", class="MagicWordBundle:Language")
     */
    public function trainAction(Language $language)
    {
        $round = $this->get('mw_manager.training')->generateTraining($language);
        $this->get('mw_manager.user')->startGame($round->getGame());

        return $this->redirectToRoute('round_play', ['id' => $round->getId()]);
    }
}
