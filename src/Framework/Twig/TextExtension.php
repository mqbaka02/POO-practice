<?php
namespace Framework\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * A bunch of extensions about text.
 * @package Framework\Twig
 */
class TextExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('exerpt', [$this, 'exerpt'])
        ];
    }

    /**
     * Returns an exerpt of a given string
     * @var string $content The text to conmpress
     * @var integer $maxlength The max length allowed
     * @return string|null
     */
    public function exerpt(string $content, int $maxlength = 100): ?string
    {
        if (mb_strlen($content) > $maxlength) {
            $exerpt= mb_substr($content, 0, $maxlength);
            $lastSpace= mb_strrpos($exerpt, ' ');
            $exerpt= mb_substr($exerpt, 0, $lastSpace);
            $exerpt.= '...';
        }
        return $exerpt;
    }
}
