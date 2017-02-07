<?php

namespace MagicWordBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MagicWordBundle\Entity\Lexicon\Lemma;
use MagicWordBundle\Entity\Lexicon\Inflection;

class EnglishImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('magicword:import-english')
            ->setDescription('import english')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
        $enForms = $em->getRepository('MagicWordBundle:Lexicon\Inflection')->getEnglishForms();

        foreach ($enForms as $enForm) {
            $lemma = $this->handleLemma($enForm, $output);

            if ($lemma) {
                preg_match_all('/:[^:]+/', $enForm['features'], $features);
                foreach ($features as $feature) {
                    foreach ($feature as $f) {
                        $inflection = $this->handleInflection($f, $lemma, $enForm['form'], $output);
                    }
                }
                $em->clear();
            }
        }
    }

    private function handleInflection($subcat, $lemma, $form, $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
        $inflectionManager = $this->getContainer()->get('mw_manager.inflection');

        $genderNames = array(
            'm' => 'masculine',
            'f' => 'feminine',
            'n' => 'neutral',
        );

        $numberNames = array(
            's' => 'singular',
            'p' => 'plural',
        );

        $personNames = array(
            '1' => 'firstPerson',
            '2' => 'secondPerson',
            '3' => 'thirdPerson',
        );

        $tenseNames = array(
            'W' => null,
            'P' => 'present',
            'K' => 'past',
            'I' => 'simplePast',
            'G' => 'present',
            'C' => null,
            'S' => null,
        );

        $moodNames = array(
            'W' => 'infinitive',
            'P' => 'indicative',
            'K' => 'participle',
            'I' => 'indicative',
            'G' => 'participle',
            'C' => null,
            'S' => null,
        );

        $gender = null;
        $number = null;
        $person = null;
        $tense = null;
        $mood = null;

        $subcats = str_split($subcat);
        foreach ($subcats as $subcat) {
            if (isset($genderNames[$subcat])) {
                $gender = $em->getRepository('MagicWordBundle:Lexicon\Gender')->findOneByValue($genderNames[$subcat]);
            } elseif (isset($numberNames[$subcat])) {
                $number = $em->getRepository('MagicWordBundle:Lexicon\Number')->findOneByValue($numberNames[$subcat]);
            } elseif (isset($personNames[$subcat])) {
                $person = $em->getRepository('MagicWordBundle:Lexicon\Person')->findOneByValue($personNames[$subcat]);
            } else {
                if (isset($tenseNames[$subcat])) {
                    $tense = $em->getRepository('MagicWordBundle:Lexicon\Tense')->findOneByValue($tenseNames[$subcat]);
                }
                if (isset($moodNames[$subcat])) {
                    $mood = $em->getRepository('MagicWordBundle:Lexicon\Mood')->findOneByValue($moodNames[$subcat]);
                }
            }
        }

        $language = $em->getRepository('InnovaLexiconBundle:Language')->find(2);

        $criteria = array_filter([
            'lemma' => $lemma,
            'gender' => $gender,
            'number' => $number,
            'person' => $person,
            'tense' => $tense,
            'mood' => $mood,
        ]);

        $inflection = $em->getRepository('MagicWordBundle:Lexicon\Inflection')->findOneBy($criteria);

        if (!$inflection) {
            $inflection = new Inflection();
            $inflection->setLemma($lemma);
            $inflection->setGender($gender);
            $inflection->setNumber($number);
            $inflection->setPerson($person);
            $inflection->setTense($tense);
            $inflection->setMood($mood);
            $inflection->setLanguage($language);
            $inflection->setContent($form);
            $inflection->setPhonetic1('');
            $inflection->setPhonetic2('');
            //$inflection->setStatus('');
            $inflection->setCleanedContent($inflectionManager->getCleanContent($form));

            $em->persist($inflection);
            $em->flush();

            $output->writeln('<info> insert form:'.$form.'</info>');
        } else {
            $output->writeln('<info> ignore form:'.$form.'</info>');
        }
    }

    private function handleLemma($enForm, $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $cat = array(
            'noun' => 'CommonNoun',
            'verb' => 'verb',
            'adjective' => 'adjective',
            'interjection' => 'interjection',
            'adverb' => 'adverb',
            'preposition' => 'preposition',
            'preposition article' => 'preposition',
            'preposition determinant' => 'preposition',
            'determiner' => 'determiner',
            'external' => null,
            'conjunction' => 'conjunction',
            'pronoun' => 'pronoun',
            'prefix' => null,
            'verbal adjective' => 'adjective',
            'nominal adjective' => 'adjective',
            'subordinating conjunction' => 'conjunction',
        );

        $subcat = array(
            'preposition determinant' => 'determinant',
            'subordinating conjunction' => 'subordination',
        );

        $lemmaContent = $enForm['lemma'];
        $lemmaCat = $enForm['lemtype'];

        $lemmaSubcatName = isset($subcat[$lemmaCat])
            ? $subcat[$lemmaCat]
            : null;

        $lemmaCatName = $cat[$lemmaCat];

        $lemmaCat = $em->getRepository('InnovaLexiconBundle:Category')->findOneByValue($lemmaCatName);
        $lemmaSubcat = $em->getRepository('MagicWordBundle:Lexicon\Subcategory')->findOneByValue($lemmaSubcatName);
        $language = $em->getRepository('InnovaLexiconBundle:Language')->find(2);

        $lemma = $em->getRepository('MagicWordBundle:Lexicon\Lemma')->findOneBy([
            'language' => $language,
            'content' => $lemmaContent,
            'category' => $lemmaCat,
            'subcategory' => $lemmaSubcat,
        ]);

        if ($lemmaCat && !$lemma) {
            $lemma = new Lemma();
            $lemma->setLanguage($language);
            $lemma->setContent($lemmaContent);
            $lemma->setCategory($lemmaCat);
            $lemma->setLocution(0);
            //$lemma->setProcessStatus(0);
            $lemma->setPhonetic1('');
            $lemma->setPhonetic2('');
            $lemma->setSubcategory($lemmaSubcat);
            //$lemma->setStatus('');

            $em->persist($lemma);
            $em->flush();
            $output->writeln('<info> insert lemma: '.$lemmaContent.'</info>');
        } else {
            $output->writeln('<info> ignore lemma: '.$lemmaContent.'</info>');
        }

        return $lemma;
    }
}
