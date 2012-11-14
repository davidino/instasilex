<?php 

require_once __DIR__.'./../vendor/autoload.php';
require __DIR__ . '/../vendor/Guzzle-silex-extension/GuzzleServiceProvider.php';

use Silex\Application;
use Guzzle\GuzzleServiceProvider;


$app = new Application();
$app['debug'] = true;

$app->register(new GuzzleServiceProvider(), array(
    'guzzle.services' => '/path/to/services.js',
    'guzzle.class_path' => '/../vendor/Guzzle/src/'
));

return $app;