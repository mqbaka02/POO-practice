<?php
require "../vendor/autoload.php";

use App\Blog\BlogModule;
use DI\ContainerBuilder;
use Framework\App;
use Framework\Renderer\RendererInterface;
// use Framework\Renderer\TwigRendererFactory;
// use Framework\Renderer\TwigRendererFactory;
// use Framework\Renderer\PHPRenderer;
// use Framework\Renderer\TwigRenderer;
use GuzzleHttp\Psr7\ServerRequest;

// use function DI\factory;
use function Http\Response\send;

$builder= new ContainerBuilder();



$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');
$builder->addDefinitions(dirname(__DIR__) . '/config.php');
$container= $builder->build();

// $renderer= new TwigRenderer(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
$renderer=  $container->get(RendererInterface::class);
var_dump($renderer);
die();

$loader= new Twig\Loader\FilesystemLoader(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
$twig= new Twig\Environment($loader, []);

$app= new App([
    BlogModule::class
], [
    'renderer'=> $renderer
]);
$response= $app->run(ServerRequest::fromGlobals());
send($response);
