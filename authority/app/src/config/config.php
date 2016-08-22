<?php
return array(
    'routes' => array(
        'test' => array(
            'pattern' => '/test',
            'config' => array(
                '_controller' => 'Anka\Authority\Controller\TestController:testAction'
            ),
        ),
    ),
    'db' => array(
        'host' => '198.1.0.12'
    ),
    'test' => 'bla123', 
);