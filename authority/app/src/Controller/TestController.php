<?php
namespace Anka\Authority\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController {
    
    /**
     * 
     * @param Request $req
     * @param Response $res
     */
    public function testAction(Request $req, Response $res){
        die('found controller');
    }
}
