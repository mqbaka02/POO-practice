<?php
require dirname(__DIR__) . "/vendor/autoload.php";

use App\Admin\AdminModule;
use App\Blog\BlogModule;
use DI\ContainerBuilder;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

$modules= [
    AdminModule::class,
    BlogModule::class
];

$builder= new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');
foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions(($module::DEFINITIONS));
    }
}

$builder->addDefinitions(dirname(__DIR__) . '/config.php');
$container= $builder->build();

// $renderer= new TwigRenderer(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
// $loader= new Twig\Loader\FilesystemLoader(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
// $twig= new Twig\Environment($loader, []);

$app= new App($container, $modules);
if (php_sapi_name() !== "cli") {
    // throw new Exception();
    $response= $app->run(ServerRequest::fromGlobals());
    send($response);
}
