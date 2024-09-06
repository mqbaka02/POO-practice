<?php
namespace Tests\Framework;

use Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    /**
     * @var Renderer
     */
    private $renderer;

    public function setUp(): void
    {
        $this->renderer= new Renderer();
        $this->renderer->addPath(__DIR__ . '/views');
    }

    public function testRenderTheRightPath()
    {
        $this->renderer->addPath('blog', __DIR__ . '/views');
        $content= $this->renderer->render('@blog/demo');
        $this->assertEquals("hello guys", $content);
    }

    public function testRenderTheDefaultPath()
    {
        $content= $this->renderer->render('demo');
        $this->assertEquals("hello guys", $content);
    }

    public function testRenderWithParams()
    {
        $content= $this->renderer->render('demoparams', ['name_'=> 'Marc']);
        $this->assertEquals("Hi Marc", $content);
    }
}
