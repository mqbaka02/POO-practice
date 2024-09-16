<?php
namespace Tests\Framework\Twig;

use Framework\Twig\TextExtension;
use PHPUnit\Framework\TestCase;

class TextExtensionTest extends TestCase
{
    /**
     * @var TextExtension
     */
    private $textExtension;

    public function setUp(): void
    {
        $this->textExtension= new TextExtension();
    }

    public function testExerptWithShortText(){
        $text= "Hello.";
        $this->assertEquals("Hello.", $this->textExtension->exerpt($text, 10));
    }

    public function testExerptWithLongText(){
        $text= "Hello People, how do you do?";
        $this->assertEquals("Hello...", $this->textExtension->exerpt($text, 10));
    }

    public function testExerptWithLongText2(){
        $text= "Hello People, how do you do?";
        $this->assertEquals("Hello People,...", $this->textExtension->exerpt($text, 16));
    }
}
