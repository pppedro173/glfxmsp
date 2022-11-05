<?php

namespace Core;

abstract class Controller
{

    protected $requestData = [];

    public function __construct($requestData)
    {
       $this->requestData = $requestData; 
    }

}