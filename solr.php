<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Lib\Object;

require 'vendor/autoload.php';
require 'Lib/Config.php';

$solrServer = new \Apache_Solr_Service($config['host'], $config['port'], $config['path']);
$res = $solrServer->search('title:solr');
print_r($res);



// $data = new Object();
// print_r($data);
exit;

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});
$app->run();