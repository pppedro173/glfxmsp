<?php

namespace App\Services;

use App\Models\Booking;
use Core\Validator;
use DateTime;

class BookingService
{
    public function bookClass(object $booking): object
    {
        Booking::insert((array) $booking);

        return $booking;
    }

    public function getBookings(): array
    {
        return Booking::get();
    }

    public  function validateCreateRequest(?object $request): void
    {
        $validation = Validator::requestStruct($request, ['name', 'date']);

        if(! $validation->success){
            throw new \Exception($validation->error, 400);
        }
    }

    public function validateBookingObj(object $booking): void
    {
        $validation = Validator::dataTypes($booking, ['name' => "string", 'date' => "string"]);

        if(! $validation->success){
            throw new \Exception($validation->error, 400);
        }
    }

    public function validateBookingDataConstraints(object $booking): void
    {
        $date = new DateTime($booking->date);
        $today = new DateTime();

        if($date < $today){
            throw new \Exception('booking date is prior to today', 400);
        }

        if(strlen($booking->name) > 256){
            throw new \Exception('Person name too long', 400);
        }
    }

}