<?php
namespace Controllers;

use Models;
use Respect\Validation\Validator as v;

class Clube extends Base
{
    /**
     * Pega todos clubes
     *
     * @return void
     */
    public function get()
    {
        $clubes = Models\Clube::get();
        
        if ($clubes) {
            echo self::encode($clubes);
        }
    }

    /**
     * Pega clube pelo id
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return boolean|Slim\Http\Response
     */
    public function getById($request, $response, $args)
    {
        $id = $args['id'];
        
        $validations = [
            v::intVal()->validate($id)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        }

		$clube = Models\Clube::find($id);

		if ($clube) {
			echo self::encode($clube);
			return true;
		}
		
		$status = 404;
		
		echo $this->error(
			'get#clubes{id}',
			$request->getUri()->getPath(),
			$status
		);
		
		return $response->withStatus($status);
    }

    /**
     * Pega todos usuários de um clube pelo id
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return boolean|Slim\Http\Response
     */
    public function getUsuariosById($request, $response, $args)
    {
        $id = $args['id'];
        
        $validations = [
            v::intVal()->validate($id)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        }
		
		$clube = Models\Clube::with('relationUsuarios.relationPlano')->find($id);

		if ($clube) {
			echo self::encode($clube);
			return true;
		}
		
		$status = 404;
		
		echo $this->error(
			'get#clubes{id}usuarios',
			$request->getUri()->getPath(),
			$status
		);
		
		return $response->withStatus($status);
    }
    
    /**
     * Inclui clube
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
        }
		
		$clube = new Models\Clube;
		$clube->clb_nome = $nome;
		$clube->save();
		$path = $request->getUri()->getPath() . '/' . $clube->clb_id;
		echo $this->resource($path); // retorna a localização do resource conforme spec para REST
		return $response->withStatus(201); // retorna status 201 quando resource é criado conforme spec para REST
    }
    
    /**
     * Atualiza o clube
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return boolean|Slim\Http\Response
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
        }
		
		$clube = Models\Clube::find($id);
		
		if ($clube) {
			$clube->clb_nome = $nome;
			$clube->save();
			return true;
		}
		
		$status = 404;
		
		echo $this->error(
			'patch#clubes{id}',
			$request->getUri()->getPath(),
			$status
		);
		
		return $response->withStatus($status);
    }
    
    /**
     * Deleta o clube
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return boolean|Slim\Http\Response
     */
    public function delete($request, $response, $args)
    {
        $id = $args['id'];

        $validations = [
            v::intVal()->validate($id)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        }
		
		$clube = Models\Clube::with('relationUsuarios')->find($id);

		if ($clube) {
			$usuarios = $clube->relationUsuarios->all();
			
			if ($usuarios) {
				$status = 403;

				echo $this->error(
					'delete#clubes{id}',
					$request->getUri()->getPath(),
					$status,
					'FK_CONSTRAINT_ABORT'
				);

				return $response->withStatus($status);
			}
			
			$clube->delete();			
			return true;
		}
		
		$status = 404;
		
		echo $this->error(
			'delete#clubes{id}',
			$request->getUri()->getPath(),
			$status
		);
		
		return $response->withStatus($status);
    }
}
