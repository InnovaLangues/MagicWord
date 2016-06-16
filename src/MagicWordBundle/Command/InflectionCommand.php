<?php

namespace MagicWordBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class InflectionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('magicword:clean')
            ->setDescription('poupulate clean content')
            ->addArgument('start', InputArgument::REQUIRED, 'start')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = $input->getArgument('start');

        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $inflections = $em->getRepository('MagicWordBundle:Lexicon\Inflection')->findByIdRange($start);
        $this->parseInflections($inflections, $start, $output);

        $output->writeln('<info>Done</info>');
    }

    private function stripAccents($str)
    {
        $str = mb_strtolower($str, 'UTF-8');
        $str = str_replace(
          array(
              'à', 'â', 'ä', 'á', 'ã', 'å',
              'î', 'ï', 'ì', 'í',
              'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
              'ù', 'û', 'ü', 'ú',
              'é', 'è', 'ê', 'ë',
              'ç', 'ÿ', 'ñ', 'œ',
          ),
          array(
              'a', 'a', 'a', 'a', 'a', 'a',
              'i', 'i', 'i', 'i',
              'o', 'o', 'o', 'o', 'o', 'o',
              'u', 'u', 'u', 'u',
              'e', 'e', 'e', 'e',
              'c', 'y', 'n', 'oe',
          ),
          $str
        );

        return $str;
    }

    private function parseInflections($inflections, $i, $output)
    {
        if ($inflections) {
            $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
            $output->writeln('<info>... ('.$i.')</info>');
            foreach ($inflections as $inflection) {
                $cleanedContent = $this->stripAccents($inflection->getContent());
                $inflection->setCleanedContent($cleanedContent);
                $em->persist($inflection);
            }
            $em->flush();
            $em->clear();
            $i = $i + 1000;
            $inflections = $em->getRepository('MagicWordBundle:Lexicon\Inflection')->findByIdRange($i);

            $this->parseInflections($inflections, $i, $output);
        }
    }
}
