<?php

namespace App\Controllers;

class BookingController extends BaseController
{
    public function create(): void
    {
        try {
            $this->success($this->requestData, 201);
        } catch (\Exception $e) {
            $this->failure($e->getMessage(), $e->getCode());
        }
    }

    public function list(): void
    {
        try {
            $this->success("listing Bookings", 200);
        } catch (\Exception $e) {
            $this->failure($e->getMessage(), $e->getCode());
        }
    }
}