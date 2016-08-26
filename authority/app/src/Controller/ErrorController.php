<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Anka\Authority\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Renders error responses
 *
 * @author Flocki
 */
class ErrorController
{
    /**
     * Renders a 404 (Not Found) response
     * @param Request $req
     * @param Response $res
     */
    public function notFoundAction(Request $req, Response $res){

        $res->headers->set('Content-Type', 'application/json');
        $res->setCharset('utf-8');
        $res->setContent(json_encode(array(
            'message' => 'Resource was not found'
        )));
        $res->setStatusCode(404);
        $res->prepare($req);
        $res->send();
    }

    /**
     * Renders a 403 (Forbiden) response
     * @param Request $req
     * @param Response $res
     */
    public function notAllowedAction(Request $req, Response $res){

        $res->headers->set('Content-Type', 'application/json');
        $res->setCharset('utf-8');
        $res->setContent(json_encode(array(
            'message' => 'Insufficent priveleges to consume this resource'
        )));
        $res->setStatusCode(403);
        $res->prepare($req);
        $res->send();
    }

    /**
     * Renders a 400 (Bad request) response
     * @param Request $req
     * @param Response $res
     */
    public function badRequestAction(Request $req, Response $res){

        $res->headers->set('Content-Type', 'application/json');
        $res->setCharset('utf-8');
        $res->setContent(json_encode(array(
            'message' => 'Only XmlHttpRequests allowed'
        )));
        $res->setStatusCode(400);
        $res->prepare($req);
        $res->send();
    }
}