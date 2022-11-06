<?php

namespace App\Services;

use App\Models\Booking;
use DateTime;

class BookingService
{
    public function bookClass(array $booking): array
    {
        Booking::insert($booking);

        return $booking;
    }

    public function getBookings(): array
    {
        return Booking::get();
    }

    public  function validateData(?object $request): void
    {
        if(is_null($request)){
            throw new \Exception('Invalid request', 400);
        }

        $this->validateBookingCreateRequestStruct($request);
        $this->validateBookingDataTypes($request);
        $this->validateBookingDataConstraints($request);
    }

    public function validateBookingCreateRequestStruct(?object $request): void
    {
        if(! property_exists($request, 'name')){
            throw new \Exception('Its mandatory to provide your name', 400);
        }

        if(! property_exists($request, 'date')){
            throw new \Exception('Its mandatory to provide a class date', 400);
        }
    }

    public function validateBookingDataTypes(object $booking): void
    {
        if(! is_string($booking->name)){
            throw new \Exception('Class name has to be a string', 400);
        }

        if(! is_string($booking->date)){
            throw new \Exception('Class capacity has to be a number', 400);
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