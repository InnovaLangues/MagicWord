<?php

namespace MagicWordBundle\Controller\GameType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TrainingController extends Controller
{
    /**
     * @Route("/train", name="train")
     */
    public function trainAction()
    {
        $round = $this->get('mw_manager.training')->generateTraining();

        return $this->redirectToRoute('round_play', ['id' => $round->getId()]);
    }
}
