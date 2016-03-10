<?php
namespace Middlewares;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Logger
{
    protected $psrLogger;

    public function __construct(LoggerInterface $logger)
    {
        $this->psrLogger = $logger;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $response = $next($request, $response);
        
        $logString = '(' . $request->getUri()->getPath() . ')';
        
        $status = $response->getStatusCode();
        
        if ($status >= 200 && $status <= 299) {
            $level = 'info';
        } elseif ($status >= 400 && $status <= 499) {
            $level = 'warning';
        } elseif ($status >= 500 && $status <= 599) {
            $level = 'alert';
        }
        
        $this->psrLogger->$level('#' . $status . ': ' . $logString);
        
        return $response;
    }
}
