<?php
use Illuminate\Database\Capsule\Manager as Capsule;

// DIC
$container = $app->getContainer();

// Monolog
$container['logger'] = function (\Slim\Container $c) {
    $settings = $c->get('settings')['logger'];
    
    $logger = new Monolog\Logger($settings['name']);
    
    $handler = new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG);
    
    $handler->setFormatter(new Monolog\Formatter\LineFormatter(
        "[%datetime%] %level_name% > %message% - %context% - %extra%\n"
    ));
    
    $logger->pushHandler($handler);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushProcessor(new Monolog\Processor\WebProcessor);
    
    return $logger;
};

// Eloquent orm
$capsule = new Capsule;

$capsule->addConnection($container->get('settings')['database']);

$capsule->setAsGlobal();

$capsule->bootEloquent();

// Injeta o container no Base controller
$container['Base'] = function ($c) {
    return new Base($c);
};
