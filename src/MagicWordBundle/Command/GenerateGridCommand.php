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
            ->addArgument('threshold', InputArgument::OPTIONAL)
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
        $threshold = $input->getArgument('threshold');
        $custom = $input->getOption('custom');

        $totalFormCount = 0;
        $keptGrid = 0;
        while ($keptGrid < $number) {
            $customLetters = ($custom)
                ? $letterManager->getCustomWeigth($customWeightedLetters)
                : $customLetters = null;

            $language = $em->getRepository('InnovaLexiconBundle:Language')->findOneByName($languageName);
            $timeStart = microtime(true);
            $grid = $gridManager->generate($language, $customLetters);
            $timeEnd = microtime(true);
            $executionTime = round($timeEnd - $timeStart, 2);
            $formCount = count($grid->getFoundableForms());


            if ($threshold && $formCount < $threshold) {
                $output->writeln('<comment>A grid has been generated but does not contains enough forms ('.$formCount.'). (generated in '.$executionTime.' sec.)</comment>');
                $gridId = $grid->getId();
                $squares = $em->getRepository('MagicWordBundle:Square')->findByGrid($gridId);
                $foundableForms = $em->getRepository('MagicWordBundle:FoundableForm')->findByGrid($gridId);
                foreach ($squares as $square) {
                    $em->remove($square);
                }
                foreach ($foundableForms as $foundableForm) {
                    $em->remove($foundableForm);
                }
                $em->remove($grid);
                $em->flush();
            } else {
                $keptGrid++;
                $output->writeln('<info>('.$keptGrid.') A grid has been generated and contains ('.$formCount.') forms (generated in '.$executionTime.' sec.)</info>');

                $totalFormCount += $formCount;
            }
            $em->clear();
        }

        $average = round($totalFormCount / $keptGrid);
        $output->writeln('<info>Done ! (average form count: '.$average.')</info>');
    }
}
