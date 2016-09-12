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
            $inflectionManager = $this->getContainer()->get('mw_manager.inflection');
            $output->writeln('<info>... ('.$i.')</info>');
            foreach ($inflections as $inflection) {
                $cleanedContent = $inflectionManager->getCleanContent($inflection->getContent());
                $this->populateStart($output, $cleanedContent, $inflection->getLanguage());
                $inflection->setCleanedContent($cleanedContent);
                $em->persist($inflection);
            }
            $em->flush();
            $em->clear();
            $i = $i + 20000;

            $inflections = $em->getRepository('MagicWordBundle:Lexicon\Inflection')->findByIdRange($i);
            $output->writeln('<info>... ('.$i.')</info>');
            //$this->parseInflections($inflections, $i, $output);
        }
    }

    private function populateStart($output, $cleanedContent, $language)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
        $startRepo = $em->getRepository('MagicWordBundle:Lexicon\InflectionStart');
        $letters = preg_split('//', $cleanedContent, -1, PREG_SPLIT_NO_EMPTY);
        $languageId = $language->getId();
        for ($i = 0; $i < count($letters); ++$i) {
            $substr = addslashes(substr($cleanedContent, 0, $i + 1));
            if (strlen($substr) > 1 && !$startRepo->search($substr, $languageId)) {
                $startRepo->insert($substr, $languageId);
            }
        }
    }
}
