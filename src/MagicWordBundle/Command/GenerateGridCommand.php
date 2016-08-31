<?php

namespace MagicWordBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class GenerateGridCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('magicword:generate-grid')
            ->setDescription('generate grids')
            ->addArgument('languageName', InputArgument::REQUIRED, 'languageName')
            ->addArgument('number', InputArgument::REQUIRED, 'number')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
        $gridManager = $this->getContainer()->get('mw_manager.grid');

        $number = $input->getArgument('number');
        $languageName = $input->getArgument('languageName');

        for ($i = 0; $i < $number; ++$i) {
            $language = $em->getRepository('MagicWordBundle:Language')->findOneByName($languageName);
            $timeStart = microtime(true);
            $grid = $gridManager->generate($language);
            $timeEnd = microtime(true);
            $executionTime = round($timeEnd - $timeStart, 2);
            $output->writeln('<info>A grid has been generated. Contains '.count($grid->getFoundableForms()).' forms. (in '.$executionTime.' sec.)</info>');
            $em->clear();
        }

        $output->writeln('<info>Done !</info>');
    }
}
