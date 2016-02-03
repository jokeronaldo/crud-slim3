<?php
namespace Controllers;

use Models;
use Respect\Validation\Validator as v;

class Plano extends Base
{
    /**
     * Pega todos planos
     *
     * @return void
     */
    public function get()
    {
        $planos = Models\Plano::get();
        
        if ($planos) {
            echo self::encode($planos);
        }
    }

    /**
     * Pega plano pelo id
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return void|Slim\Http\Response
     */
    public function getById($request, $response, $args)
    {
        $id = $args['id'];
        
        $validations = [
            v::intVal()->validate($id)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        } else {
            $plano = Models\Plano::find($id);

            if ($plano) {
                echo self::encode($plano);
            } else {
                $status = 404;
                echo $this->error('get#plano{id}', $request->getUri()->getPath(), $status);
                return $response->withStatus($status);
            }
        }
    }

    /**
     * Pega todos usuários de um plano pelo id
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return void|Slim\Http\Response
     */
    public function getUsuariosById($request, $response, $args)
    {
        $id = $args['id'];
        
        $validations = [
            v::intVal()->validate($id)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        } else {
            $plano = Models\Plano::with('relationUsuarios.relationClube')->find($id);

            if ($plano) {
                echo self::encode($plano);
            } else {
                $status = 404;
                echo $this->error('get#planos{id}', $request->getUri()->getPath(), $status);
                return $response->withStatus($status);
            }
        }
    }
    
    /**
     * Inclui plano
     * $request e $response usam interface psr7
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @return Slim\Http\Response
     */
    public function set($request, $response)
    {
        $nome = $this->httpPost('nome');
        
        $validations = [
            v::stringType()->length(2)->validate($nome)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        } else {
            $plano = new Models\Plano;

            $plano->pln_nome = $nome;

            $plano->save();

            $path = $request->getUri()->getPath() . '/' . $plano->pln_id;

            echo $this->resource($path); // retorna a localização do resource conforme spec para REST

            return $response->withStatus(201); // retorna status 201 quando resource é criado conforme spec para REST
        }
    }
    
    /**
     * Atualiza o plano
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return void|Slim\Http\Response
     */
    public function update($request, $response, $args)
    {
        $id = $args['id'];
        $nome = $this->httpPost('nome');
        
        $validations = [
            v::intVal()->validate($id),
            v::stringType()->length(2)->validate($nome)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        } else {
            $plano = Models\Plano::find($id);
            
            if ($plano) {
                $plano->pln_nome = $nome;

                $plano->save();
            } else {
                $status = 404;
                
                echo $this->error(
                    'patch#planos{id}',
                    $request->getUri()->getPath(),
                    $status
                );
                
                return $response->withStatus($status);
            }
        }
    }
    
    /**
     * Deleta o plano
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return void|Slim\Http\Response
     */
    public function delete($request, $response, $args)
    {
        $id = $args['id'];

        $validations = [
            v::intVal()->validate($id)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        } else {
            $plano = Models\Plano::with('relationUsuarios')->find($id);

            if ($plano) {
                $usuarios = $plano->relationUsuarios->all();
                
                if ($usuarios) {
                    $status = 403;

                    echo $this->error(
                        'delete#planos{id}',
                        $request->getUri()->getPath(),
                        $status,
                        'FK_CONSTRAINT_ABORT'
                    );

                    return $response->withStatus($status);
                } else {
                    $plano->delete();
                }
            } else {
                $status = 404;
                
                echo $this->error(
                    'delete#planos{id}',
                    $request->getUri()->getPath(),
                    $status
                );
                
                return $response->withStatus($status);
            }
        }
    }
}
