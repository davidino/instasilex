<?php

require_once __DIR__.'./../vendor/autoload.php';
require __DIR__ . '/../vendor/Guzzle-silex-extension/GuzzleServiceProvider.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Guzzle\GuzzleServiceProvider;
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;


$app = new Application();
$app['debug'] = true;

$app->register(new GuzzleServiceProvider(), array(
    'guzzle.services' => '/path/to/services.js',
    'guzzle.class_path' => '/../vendor/Guzzle/src/'
));

$app->get('/user/{id}', function($id) use($app) {

	// Create a client and provide a base URL
	$client = new Client('https://api.instagram.com');
/*
	$oauth = new OauthPlugin(array(
	    'client_id'       => 'a5bd827ca49447debd2bd6fe03739aaa',
	    'client_secret'   => '84bd1b1d71114b41a0b3a05ba2ab6987',
	    'access_token'    => '943706.a5bd827.9984d0f7a5f642c589a06839baa4b6be',
	    'URL'			  => 'http://localhost/~davidino',
	    'redirect_uri'    => 'http://localhost/~davidino/followgram/web/index.php/code',
	));

	$client->addSubscriber($oauth);*/

	// Create a request with basic Auth
	$request = $client->get('/v1/users/'.$id.'?client_id=a5bd827ca49447debd2bd6fe03739aaa');

	// Send the request and get the response
	$response = $request->send()->json();


    return new Response($response['data']['username']);
});

$app->get('/code',function(Request $request) use ($app){
	echo $request->get('code');
});

$app->run();

/*
curl \-F 'client_id=a5bd827ca49447debd2bd6fe03739aaa' \
    -F 'client_secret=84bd1b1d71114b41a0b3a05ba2ab6987' \
    -F 'grant_type=authorization_code' \
    -F 'redirect_uri=http://localhost/~davidino/followgram/web/index.php/code' \
    -F 'code=6b37ff7660624dd5a03f5b7684858876' \https://api.instagram.com/oauth/access_token

{"access_token":"943706.a5bd827.9984d0f7a5f642c589a06839baa4b6be",
	"user":{"username":"ingdavidino","bio":"","website":"","profile_picture":"http:\/\/images.instagram.com\/profiles\/profile_943706_75sq_1311375011.jpg","full_name":"","id":"943706"}}%   

*/