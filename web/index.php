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
		'VK_TOKEN' => 'b08a880df0df92902b33fe22cf60e3efa8ac6e8fd99e189feb3ef0f0e2bc5529578a691a95045506b532a',
		'VK_SECRET_TOKEN' => 'qwezHGDSJFhgjhs',
		'VK_CONF_CODE' => '52503fa1'
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
				'message' =>'Тест',
				'access_token' => $conf['VK_TOKEN'],
				'v' => '5.50'
			];

			file_get_contents('https://api.vk.com/method/messages.send?'.http_build_query($req_params));

			break;
	}

	return 'no ok!'; 
});

$app->run();
