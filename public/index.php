<?php
require "../vendor/autoload.php";

use App\Blog\BlogModule;
use Framework\App;
use Framework\Renderer\PHPRenderer;
use Framework\Renderer\TwigRenderer;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

$renderer= new TwigRenderer(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');

$loader= new Twig\Loader\FilesystemLoader(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
$twig= new Twig\Environment($loader, []);

$app= new App([
    BlogModule::class
], [
    'renderer'=> $renderer
]);
$response= $app->run(ServerRequest::fromGlobals());
send($response);
