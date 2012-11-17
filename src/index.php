<?php

$app = require_once __DIR__ . '/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;


$app->get('/user/{id}', function($id) use($app) {

	$access_token = '943706.a5bd827.9984d0f7a5f642c589a06839baa4b6be';
	$client_id    = 'a5bd827ca49447debd2bd6fe03739aaa';

	// Create a client and provide a base URL
	$client = new Client('https://api.instagram.com');

	$counter = 0;
	$pagination['next_max_id'] = null;

	while (count($pagination) > 0 ) {

		$next_max_id = $pagination['next_max_id'];

		$url = sprintf("/v1/users/%d/media/recent/?access_token=%s&max_id=%s",$id,$access_token,$next_max_id);

		$request = $client->get($url);
		$response = $request->send()->json();

		$pagination = $response['pagination'];

		$counter += count($response['data']);

	}

    return new Response($counter);
});

$app->get('/code',function(Request $request) use ($app){
	echo $request->get('code');
});

$app->run();

/*
curl \-F 'client_id=a5bd827ca49447debd2bd6fe03739aaa' \
    -F 'client_secret=84bd1b1d71114b41a0b3a05ba2ab6987' \
    -F 'grant_type=authorization_code' \
    -F 'redirect_uri=http://localhost/~davidino/instagram-silex/web/index.php/code' \
    -F 'code=6b37ff7660624dd5a03f5b7684858876' \https://api.instagram.com/oauth/access_token

{"access_token":"943706.a5bd827.9984d0f7a5f642c589a06839baa4b6be",
	"user":{"username":"ingdavidino","bio":"","website":"","profile_picture":"http:\/\/images.instagram.com\/profiles\/profile_943706_75sq_1311375011.jpg","full_name":"","id":"943706"}}%   

*/