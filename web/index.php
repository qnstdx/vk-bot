<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

$app->get('/', function() use($app) {
  return 'Hello, world!';
});

$app->post('/bot', function() use($app) {
	$conf = [
		'VK_TOKEN' => /*You token*/,
		'VK_SECRET_TOKEN' => /*You secret token*/,
		'VK_CONF_CODE' => /*You confirmation code*/
	];

	$data = json_decode(file_get_contents('php://input'));

	if (!$data) 
		return 'no ok';

	if ($data->secret !== $conf['VK_SECRET_TOKEN'] && $data->type !== 'confirmation')
		return 'no ok!';

	switch ($data->type) {
		case 'confirmation':
			return $conf['VK_CONF_CODE'];
			break;
		case 'message_new':
			$req_params = [
				'user_id' => $data->object->user_id,
				'message' => $data->object->body,
				'access_token' => $conf['VK_TOKEN'],
				'v' => '5.50'
			];

			file_get_contents('https://api.vk.com/method/messages.send?'.http_build_query($req_params));

			break;
	}

	return 'no ok!'; 
});

$app->run();
