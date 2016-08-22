<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Anka\Authority\Models;

use Anka\Authority\Models\Config;
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
        $res->headers->set('Content-Type', 'application/json');
        $res->setCharset('utf-8');
        
        try{
            /*
            if(!$req->isXmlHttpRequest()){
                throw new \Exception();
            }
            */
            $context = new RequestContext('/');
            $matcher = new UrlMatcher($this->_routes, $context);
            $params = $matcher->match($req->getPathInfo());
            
            $split = explode(':', $params['_controller']);
            $controllerClass = $split[0];
            $action = $split[1];
            $controller = new $controllerClass();
            $controller->$action($req, $res);
            
        } catch (\Exception $ex) {
            
            $res->setContent(json_encode(array()));
            $res->setStatusCode(404);
            $res->prepare($req);
            $res->send();
        }
    }
}
