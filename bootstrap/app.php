<?php
require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([

	'settings' => [
		'display' => true
	]
]);

$container = $app->getContainer();

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
		return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->withJson('Nieprawidłowy link');
			   };
};

$container['ApiController'] = function(){
	return new \App\Controllers\ApiController;
};

require __DIR__ . '/../app/routes.php';