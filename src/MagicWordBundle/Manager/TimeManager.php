<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("mw_manager.time")
 */
class TimeManager
{
    protected $translator;

    /**
     * @DI\InjectParams({
     *      "translator" = @DI\Inject("translator"),
     * })
     */
    public function __construct($translator)
    {
        $this->translator = $translator;
    }

    public function getDiffInSeconds($start, $end)
    {
        $start = strtotime($start->format('Y-m-d H:i:s'));
        $end = strtotime($end->format('Y-m-d H:i:s'));

        return $end - $start;
    }

    public function pluralize($count, $text)
    {
        $str = $count.(($count == 1) ? (" $text") : (" ${text}s"));
        $translation = $this->translator->trans($str);

        return $translation;
    }

    public function getDiff($start, $end)
    {
        $interval = $end->diff($start);
        if ($v = $interval->y >= 1) {
            return $this->pluralize($interval->y, 'year');
        }
        if ($v = $interval->m >= 1) {
            return $this->pluralize($interval->m, 'month');
        }
        if ($v = $interval->d >= 1) {
            return $this->pluralize($interval->d, 'day');
        }
        if ($v = $interval->h >= 1) {
            return $this->pluralize($interval->h, 'hour');
        }
        if ($v = $interval->i >= 1) {
            return $this->pluralize($interval->i, 'minute');
        }

        return $this->pluralize($interval->s, 'second');
    }
}
