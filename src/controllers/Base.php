<?php
namespace Controllers;

use \Slim\Container;

class Base
{

    /**
     * Slim DI Container
     *
     * @var \Slim\Container
     */
    protected $container;

    /**
     * Construtor
     *
     * @param object $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    /**
     * Pega uma variável $_GET definda em request
     *
     * @param string $key
     * @return string|null
     */
    public function httpGet($key)
    {
        if (isset($this->container->request->getQueryParams()[$key])) {
            return $this->container->request->getQueryParams()[$key];
        } else {
            return null;
        }
    }

    /**
     * Pega uma variável $_POST definda em request
     *
     * @param string $key
     * @return string|null
     */
    public function httpPost($key)
    {
        if (isset($this->container->request->getParsedBody()[$key])) {
            return $this->container->request->getParsedBody()[$key];
        } else {
            return null;
        }
    }
    
    /**
     * Transforma um objeto em uma string no formato json
     *
     * @param object $data
     * @return string
     * @throws \Exception Quando $data não é um objeto
     */
    public static function encode($data)
    {
        if (!is_object($data)) {
            throw new \Exception('$data deve ser um objeto.');
        } else {
            return json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;
        }
    }
    
    /**
     * Cria um objeto de erro em string no formato json
     *
     * @param string $code
     * @param string $path
     * @param string $status
     * @param string $extra
     * @return string
     */
    public static function error($code, $path, $status, $extra = '')
    {
        $error = new \StdClass;
        
        $error->error = [
            'code' => $code,
            'path' => $path,
            'status' => $status
        ];
        
        if ($extra) {
            $error->error['extra'] = $extra;
        }

        return self::encode($error);
    }
    
    /**
     * Cria um objeto de resource em string no formato json
     *
     * @param string $request
     * @param string $path
     * @return string
     */
    public function resource($path)
    {
        $uri = $this->container->request->getUri();

        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $port = $uri->getPort();
        
        $location = $scheme . '://' . $host . ($port ? ':' . $port : null) . '/' . $path;
        
        $resource = new \StdClass;
        
        $resource->resource = [
            'location' => $location
        ];

        return self::encode($resource);
    }
    
    /**
     * Checa uma lista de expressões booleanas
     *
     * @param array $validations
     * @return bool
     * @throws \Exception Quando $validations não é um array
     */
    public static function validate($validations)
    {
        if (!is_array($validations)) {
            throw new \Exception('$validations deve ser um array de valores booleanos.');
        } else {
            foreach ($validations as $v) {
                if ($v === false) {
                    return false;
                }
            }
        }
        
        return true;
    }
}
