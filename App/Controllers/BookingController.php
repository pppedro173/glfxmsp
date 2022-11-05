<?php

namespace App\Controllers;

use Core\Controller as BaseController;


class BookingController extends BaseController
{
    public function create(): object
    {
        return $this->requestData;
    }

    public function list(): string
    {
        return "listing Bookings";
    }
}