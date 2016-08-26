<?php

namespace Anka\Authority\Models;

use Anka\Authority\Models\Config;
use Anka\Authority\Controller\ErrorController;
use Anka\Authority\Models\Exceptions\Http\BadRequestException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Initializes routing component and starts routing
 *
 * @author Flocki
 */
class Router {
    
    private $_routes;
    
    /**
     * Sets up RouteCollection
     */
    public function __construct() {
    
        $this->_routes = new RouteCollection();
        
        foreach(Config::get('routes') as $name => $route){
            $this->_routes->add($name, new Route(
                $route['pattern'], $route['config']     
            ));
        }
    }
    
    /**
     * Applies routing
     */
    public function route(){
        $req = Request::createFromGlobals();
        $res = new Response();
        try{
            if(!$req->isXmlHttpRequest()){
                throw new BadRequestException();
            }
            $context = new RequestContext('/');
            $matcher = new UrlMatcher($this->_routes, $context);
            $params = $matcher->match($req->getPathInfo());
            
            $split = explode(':', $params['_controller']);
            $controllerClass = $split[0];
            $action = $split[1];
            $controller = new $controllerClass();
            $controller->$action($req, $res);
            
        } catch (\Exception $ex) {
            $ec = new ErrorController();
            if($ex instanceof BadRequestException){
                $ec->badRequestAction($req, $res);
            }
            if($ex instanceof ResourceNotFoundException){
                $ec->notFoundAction($req, $res);
            }
        }
    }
}
