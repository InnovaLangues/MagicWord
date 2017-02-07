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
        $customWeightedLetters = $this->getContainer()->getParameter('custom_letters');

        $number = $input->getArgument('number');
        $languageName = $input->getArgument('languageName');
        $custom = $input->getOption('custom');

        $totalFormCount = 0;
        for ($i = 0; $i < $number; ++$i) {
            $customLetters = ($custom)
                ? $letterManager->getCustomWeigth($customWeightedLetters)
                : $customLetters = null;

            $language = $em->getRepository('InnovaLexiconBundle:Language')->findOneByName($languageName);
            $timeStart = microtime(true);
            $grid = $gridManager->generate($language, $customLetters);
            $timeEnd = microtime(true);
            $executionTime = round($timeEnd - $timeStart, 2);
            $formCount = count($grid->getFoundableForms());
            $totalFormCount += $formCount;
            $output->writeln('<info>A grid has been generated. Contains '.$formCount.' forms. (in '.$executionTime.' sec.)</info>');
            $em->clear();
        }

        $average = round($totalFormCount / $number);
        $output->writeln('<info>Done ! (average form count: '.$average.')</info>');
    }
}
