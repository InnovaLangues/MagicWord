<?php

namespace MagicWordBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateGridCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('magicword:generate-grid')
            ->setDescription('generate grids')

            ->addArgument('languageName', InputArgument::REQUIRED)
            ->addArgument('number', InputArgument::REQUIRED)
            ->addOption('custom', 'c', InputOption::VALUE_NONE)
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
        $gridManager = $this->getContainer()->get('mw_manager.grid');
        $letterManager = $this->getContainer()->get('mw_manager.letter_language');

        $number = $input->getArgument('number');
        $languageName = $input->getArgument('languageName');
        $custom = $input->getOption('custom');

        if ($custom) {
            $customWeightedLetters = $this->getContainer()->getParameter('custom_letters');
            $customLetters = $letterManager->getCustomWeigth($customWeightedLetters);
        } else {
            $customLetters = null;
        }

        for ($i = 0; $i < $number; ++$i) {
            $language = $em->getRepository('MagicWordBundle:Language')->findOneByName($languageName);
            $timeStart = microtime(true);
            $grid = $gridManager->generate($language, $customLetters);
            $timeEnd = microtime(true);
            $executionTime = round($timeEnd - $timeStart, 2);
            $output->writeln('<info>A grid has been generated. Contains '.count($grid->getFoundableForms()).' forms. (in '.$executionTime.' sec.)</info>');
            $em->clear();
        }

        $output->writeln('<info>Done !</info>');
    }
}
