<?php

namespace Core;

abstract class Controller
{

    protected $requestData = [];

    public function __construct(?object $requestData)
    {
       $this->requestData = $requestData; 
    }

}