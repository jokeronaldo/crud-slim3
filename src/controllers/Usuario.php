<?php
namespace Controllers;

use Models;
use Respect\Validation\Validator as v;

class Usuario extends Base
{
    /**
     * Pega váriaveis $_POST necessárias para inclusão/atualização do usuário
     *
     * @return void
     */
    public function getVars()
    {
        $vars = [
            'nome' => $this->httpPost('nome'),
            'sobrenome' => $this->httpPost('sobrenome'),
            'cpf' => $this->httpPost('cpf'),
            'telefone' => $this->httpPost('telefone'),
            'email' => $this->httpPost('email'),
            'nascimento' => $this->httpPost('nascimento'),
            'endereco' => $this->httpPost('endereco'),
            'clube' => $this->httpPost('clube'),
            'plano' => $this->httpPost('plano'),
            'titular' => $this->httpPost('titular')
        ];
        
        return $vars;
    }
    
    public function validatePostVars($vars)
    {
        $validations = [
            v::stringType()->length(2)->validate($vars['nome']),
            v::stringType()->length(2)->validate($vars['sobrenome']),
            v::cpf()->validate($vars['cpf']),
            v::email()->validate($vars['email']),
            v::intVal()->validate($vars['clube']),
            v::intVal()->validate($vars['plano'])
        ];
        
        if ($vars['nascimento']) {
            $validations[] = v::date()->validate($vars['nascimento']);
        }
        
        if ($vars['titular']) {
            $validations[] = v::intVal()->validate($vars['titular']);
        }
        
        return $validations;
    }
    
    public function validatePatchVars($vars)
    {
        $validations = [
            v::intVal()->validate($vars['id']),
            v::stringType()->length(2)->validate($vars['nome']),
            v::stringType()->length(2)->validate($vars['sobrenome'])
        ];
        
        if ($vars['nascimento']) {
            $validations[] = v::date()->validate($vars['nascimento']);
        }
        
        return $validations;
    }
    
    /**
     * Emite uma reposta 403 (proibido)
     * $request e $response usam interface psr7
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param string $extra
     * @return Slim\Http\Response
     */
    public function castForbidden($request, $response, $extra)
    {
        $status = 403;

        echo $this->error(
            'set#usuarios',
            $request->getUri()->getPath(),
            $status,
            $extra
        );

        return $response->withStatus($status);
    }
    
    /**
     * Pega todos usuarios
     *
     * @return void
     */
    public function get()
    {
        $usuarios = Models\Usuario::get();

        if ($usuarios) {
            echo self::encode($usuarios);
        }
    }

    /**
     * Pega usuario pelo id
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
            $usuario = Models\Usuario::with('relationClube', 'relationPlano')
                ->find($id);

            if ($usuario) {
                echo self::encode($usuario);
            } else {
                $status = 404;
                
                echo $this->error(
                    'get#usuarios{id}',
                    $request->getUri()->getPath(),
                    $status
                );
                
                return $response->withStatus($status);
            }
        }
    }

    /**
     * Pega todos dependentes do usuario pelo id
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return void|Slim\Http\Response
     */
    public function getDependentesById($request, $response, $args)
    {
        $id = $args['id'];
        
        $validations = [
            v::intVal()->validate($id)
        ];
        
        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        } else {
            $usuario = Models\Usuario::with('relationClube', 'relationPlano', 'relationDependentes')
                ->find($id);

            if ($usuario) {
                echo self::encode($usuario);
            } else {
                $status = 404;
                
                echo $this->error(
                    'get#usuarios{id}',
                    $request->getUri()->getPath(),
                    $status
                );
                
                return $response->withStatus($status);
            }
        }
    }

    /**
     * Inclui usuário
     * $request e $response usam interface psr7
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @return Slim\Http\Response
     */
    public function set($request, $response)
    {
        $vars = $this->getVars();
        
        $validations = $this->validatePostVars($vars);

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        } else {
            $email_existe = Models\Usuario::where('usu_email', $vars['email'])->get()->first();
            
            $cpf_existe = Models\Usuario::where('usu_cpf', $vars['cpf'])->get()->first();
            
            $clube_existe = Models\Clube::where('clb_id', $vars['clube'])->get()->first();
            
            $plano_existe = Models\Plano::where('pln_id', $vars['plano'])->get()->first();
            
            if ($vars['titular']) {
                $titular_existe = Models\Usuario::where('usu_titular', $vars['titular'])->get()->first();
            }
            
            if (!$clube_existe || !$plano_existe || ($vars['titular'] && !$titular_existe)) {
                return $this->castForbidden($request, $response, 'FK_CONSTRAINT_MISS');
            } elseif ($email_existe || $cpf_existe) {
                return $this->castForbidden($request, $response, 'UNIQUE_FIELDS_ALREADY_TAKEN');
            } else {
                $usuario = new Models\Usuario;

                $usuario->usu_nome = $vars['nome'];
                $usuario->usu_sobrenome = $vars['sobrenome'];
                $usuario->usu_cpf = $vars['cpf'];
                $usuario->usu_email = $vars['email'];
                $usuario->usu_nascimento = $vars['nascimento'];
                $usuario->usu_telefone = $vars['telefone'];
                $usuario->usu_endereco = $vars['endereco'];
                $usuario->usu_clube = $vars['clube'];
                $usuario->usu_plano = $vars['plano'];
                
                if ($vars['titular']) {
                    $usuario->usu_titular = $vars['titular']; // Define o usuário como dependente
                }
                
                $usuario->save();

                $path = $request->getUri()->getPath() . '/' . $usuario->usu_id;

                echo $this->resource($path); // retorna a localização do resource conforme spec para REST

                return $response->withStatus(201); // retorna status 201 quando resource é criado conforme spec para REST
            }
        }
    }
    
    /**
     * Atualiza usuário
     * $request e $response usam interface psr7
     * $args contém os argumentos informados na rota
     *
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return Slim\Http\Response
     */
    public function update($request, $response, $args)
    {
        $vars = $this->getVars();
        
        $vars['id'] = $args['id'];
        
        $validations = $this->validatePatchVars($vars);

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        } else {
            $usuario = Models\Usuario::find($vars['id']);

            if ($usuario) {
                $usuario->usu_nome = $vars['nome'];
                $usuario->usu_nascimento = $vars['nascimento'];
                $usuario->usu_sobrenome = $vars['sobrenome'];
                $usuario->usu_telefone = $vars['telefone'];
                $usuario->usu_endereco = $vars['endereco'];
                
                $usuario->save();
            } else {
                $status = 404;
                
                echo $this->error(
                    'patch#usuarios{id}',
                    $request->getUri()->getPath(),
                    $status
                );
                
                return $response->withStatus($status);
            }
        }
    }
    
    /**
     * Deleta o usuario
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
            $usuario = Models\Usuario::with('relationDependentes')->find($id);

            if ($usuario) {
                $dependentes = $usuario->relationDependentes->all();
                
                if ($dependentes) {
                    $status = 403;

                    echo $this->error(
                        'delete#usuarios{id}',
                        $request->getUri()->getPath(),
                        $status,
                        'FK_CONSTRAINT_ABORT'
                    );

                    return $response->withStatus($status);
                } else {
                    $usuario->delete();
                }
            } else {
                $status = 404;
                
                echo $this->error(
                    'delete#usuarios{id}',
                    $request->getUri()->getPath(),
                    $status
                );
                
                return $response->withStatus($status);
            }
        }
    }
}
