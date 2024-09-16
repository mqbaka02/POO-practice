<?php
namespace Tests\Framework\Twig;

use DateTime;
use Framework\Twig\TimeExtension;
use PHPUnit\Framework\TestCase;

class TimeExtensionTest extends TestCase
{
    private $timeExtension;
    public function setUp(): void
    {
        $this->timeExtension= new TimeExtension();
    }

    public function testDateFormat()
    {
        $date= new DateTime();
        $format= 'd/m/Y H:i';
        $result= '<span class="timeago" datetime="' . $date->format(DateTime::ISO8601_EXPANDED) . '">' . $date->format($format) . '</span>';
        $this->assertEquals($result, $this->timeExtension->ago($date));
    }
}
