<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Language;

class ApiController extends Controller
{
    /**
     * @Route("/api/grid/{id}/{letters}", name="api_grid_from_letters", requirements={"letters" = "[a-z]{16}"})
     * @ParamConverter("language", class="MagicWordBundle:Language")
     * @Method("GET")
     */
    public function testGridFromLetters(Language $language, $letters)
    {
        $time_start = microtime(true);
        $lettersArray = str_split($letters);
        $grid = $this->get('mw_manager.grid')->generate($language, $lettersArray);
        $foundables = $grid->getFoundableForms();
        $formsJSON = [];
        $lemmasJSON = [];
        $lemmas = [];
        $inflections = [];

        foreach ($foundables as $foundable) {
            $inflectionsJSON = [];
            foreach ($foundable->getInflections() as $inflection) {
                $inflections[] = $inflection;
                $lemma = $inflection->getLemma();
                $lemmas[] = $lemma;
                $inflectionsJSON[] = [
                    'lemma' => $lemma->getContent(),
                    'POS' => $lemma->getCategory() ? $lemma->getCategory()->getValue() : null,
                    'number' => $inflection->getNumber() ? $inflection->getNumber()->getValue() : null,
                    'gender' => $inflection->getGender() ? $inflection->getGender()->getValue() : null,
                    'person' => $inflection->getPerson() ? $inflection->getPerson()->getValue() : null,
                    'tense' => $inflection->getTense() ? $inflection->getTense()->getValue() : null,
                    'mood' => $inflection->getMood() ? $inflection->getMood()->getValue() : null,
                ];
            }
            $formsJSON[] = [
                'form' => $foundable->getForm(),
                'points' => $foundable->getPoints(),
                'inflections' => $inflectionsJSON,
            ];
        }

        $lemmas = array_unique($lemmas,  SORT_REGULAR);
        foreach ($lemmas as $lemma) {
            $lemmasJSON[] = [
                'lemma' => $lemma->getContent(),
                'POS' => $lemma->getCategory() ? $lemma->getCategory()->getValue() : null,
                'POS2' => $lemma->getSubcategory() ? $lemma->getSubcategory()->getValue() : null,
            ];
        }

        $combos = $this->get('mw_manager.grid')->getCombos($inflections);
        $comboTotalLength = 0;
        $comboCount = count($combos);
        foreach ($combos as $combo) {
            $comboTotalLength += count($combo['inflections']);
        }
        $comboAverage = $comboCount > 0 ? round($comboTotalLength / $comboCount, 2) : 0;

        $time_end = microtime(true);
        $time = $time_end - $time_start;

        $out = [
            'grid_id' => $grid->getId(),
            'language' => $language->getName(),
            'generation_time' => round($time, 2).' s.',
            'letters' => $letters,
            'forms_count' => count($grid->getFoundableForms()),
            'lemmas_count' => count($lemmas),
            'combos_count' => $comboCount,
            'combo_average' => $comboAverage,
            'forms' => $formsJSON,
            'lemmas' => $lemmasJSON,
            'combos' => $combos,
        ];

        $response = new JsonResponse($out);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
}
