#!/usr/bin/env php
<?php

//Bootstrap our Silex application
$app = require __DIR__ . '/bootstrap.php';


//Include the namespaces of the components we plan to use
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Guzzle\Http\Client;


class Crawler extends Command
{
	protected function configure()
	{
		$this
		->setName('Follogram:sync')
			->setDefinition( array(
		 		//Create a "--test" optional parameter
		 		new InputOption('test', '', InputOption::VALUE_NONE, 'Test mode'),
			) )
		->setDescription('Synchronize /v1/users/<user_id>/media/recent/')
		->addArgument(
			'user_id',
			InputArgument::REQUIRED,
			'user identification'
		)
		->setHelp('Usage: <info>./console.php sync [--test]</info>');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{

		$access_token = '943706.a5bd827.9984d0f7a5f642c589a06839baa4b6be';
		$client_id    = 'a5bd827ca49447debd2bd6fe03739aaa';

		$client = new Client('https://api.instagram.com');

		$counter = 0;
		$pagination['next_max_id'] = null;

		while (count($pagination) > 0 ) {
			$next_max_id = $pagination['next_max_id'];
			$url = sprintf("/v1/users/%d/media/recent/?access_token=%s&max_id=%s",$input->getArgument('user_id'),$access_token,$next_max_id);
			$request = $client->get($url);
			$response = $request->send()->json();
			$pagination = $response['pagination'];
			$counter += count($response['data']);
		}

		$output->write('<info>photo<info>: ');
		$output->writeln($counter);
	}
};


//Instantiate our Console application
$console = new Application('Followgram', '0.1');
//Register a command to run from the command line
//Our command will be started with "./console.php sync"
$console->add(new Crawler);

$console->run();