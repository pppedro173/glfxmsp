<?php

namespace App\Controllers;

use App\Services\LessonService;
use App\Services\BookingService;

class BookingController extends BaseController
{
    /**
     * @var LessonService
    */
    protected $lessonService;

    /**
     * @var BookingService
    */
    protected $bookingService;

    public function __construct(?object $requestData)
    {
        parent::__construct($requestData);
        $this->lessonService = new LessonService;
        $this->bookingService = new BookingService;
    }

    public function create(): void
    {
        try {
            $this->bookingService->validateCreateRequest($this->requestData);
            
            $booking = (object) [
                'name' => $this->requestData->name,
                'date' => $this->requestData->date,
            ];

            $this->bookingService->validateBookingObj($booking);

            $this->bookingService->validateBookingDataConstraints($booking);

            if(! $this->lessonService->lessonExists($booking->date)){
                throw new \Exception('No class availlable at date ' . $booking->date, 404);
            }

            $bookingInserted = $this->bookingService->bookClass($booking);

            $this->success($bookingInserted, 200);
        } catch (\Exception $e) {
            $this->failure($e->getMessage(), $e->getCode());
        }
    }

    public function list(): void
    {
        try {
            $bookings = $this->bookingService->getBookings();

            if(! $bookings){
                throw new \Exception('bookings not found.', 404);
            }

            $this->success($bookings, 200);
        } catch (\Exception $e) {
            $this->failure($e->getMessage(), $e->getCode());
        }
    }
}