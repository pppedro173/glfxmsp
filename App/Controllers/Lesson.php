<?php

namespace App\Controllers;

use Core\Controller as BaseController;

class Lesson extends BaseController
{
    public function create(): object
    {
        return $this->requestData;
    }

    public function list(): string
    {
        return "listing Classes";
    }
}