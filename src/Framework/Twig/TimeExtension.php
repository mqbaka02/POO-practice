<?php
namespace Framework\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TimeExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('ago', [$this, 'ago'], ['is_safe'=> ['html']])
        ];
    }

    public function ago(?DateTime $date = null, string $format = 'd/m/Y H:i'): ?string
    {
        if (is_null($date)) {
            return '';
        }
        return '<span class="timeago" datetime="' . $date->format(DateTime::ISO8601_EXPANDED) . '">' . $date->format($format) . '</span>';
    }
}
