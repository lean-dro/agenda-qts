<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require_once 'model/conexao.php';
require_once 'model/Contato.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/contatos', function (Request $request, Response $response, array $args) {
    $contato = new Contato();
    $lista = $contato->listar();
    $response->getBody()->write(json_encode($lista, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->get('/contato/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $contato = new Contato();
    $lista = $contato->listarContato($id);
    $response->getBody()->write(json_encode($lista, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->post('/add', function (Request $request, Response $response, array $args) {
    $post = $request->getParsedBody();
    $contato = new Contato();
    $contato->setNome($post['nome']);
    $contato->setTelefone($post['telefone']);
    $contato->setEmail($post['email']);
    $contato->setCelular($post['celular']);
    $id = $contato->inserir($contato);

    $lista = $contato->listarContato($id);
    $response->getBody()->write(json_encode($lista, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->put('/update', function (Request $request, Response $response, array $args) {
    $contato = new Contato();
    $dados = file_get_contents("php://input");
    $array = json_decode($dados);

    $contato->setId($array->id);
    $contato->setNome($array->nome);
    $contato->setTelefone($array->telefone);
    $contato->setEmail($array->email);
    $contato->setCelular($array->celular);
    $id = $contato->update($contato);

    $lista = $contato->listarContato($id);
    $response->getBody()->write(json_encode($lista, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->delete('/delete/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $contato = new Contato();
    $contato->setId($id);
    $contato->delete($contato);

    $response->getBody()->write("Contato excluído");

    return $response;
});


$app->run();
