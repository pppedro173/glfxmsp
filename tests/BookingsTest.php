<?php declare(strict_types=1);

namespace Tests;

use App\Controllers\BookingController;
use App\Controllers\LessonController;
use PHPUnit\Framework\TestCase;

class BookingsTest extends TestCase
{
    public function testGetBookingsError(): void
    {
        $this->emptyDb();

        $bookingsController = new BookingController((object)[]);
                
        $response = $bookingsController->list();

        $this->assertEquals($response, '{"error":"bookings not found."}');
    }

    public function testGetBookingsSuccess(): void
    {
        $this->emptyDb();

        $lessonController = new LessonController((object)[
            "name" => "zumba",
            "startDate" => "2023-01-01",
            "endDate" => "2023-01-31",
            "capacity" => 20
        ]);

        $lessonController->create();

        $bookingsController = new BookingController((object)[
            "name" => "Pedro",
            "date" => "2023-01-01"]
        );

        $bookingsController->create();

        $response = $bookingsController->list();

        $this->assertEquals($response, '{"data":[{"name":"Pedro","date":"2023-01-01"}]}');

        $this->emptyDb();
    }

    public function testCreateBookings(): void
    {
        $lessonController = new LessonController((object)[
            "name" => "zumba",
            "startDate" => "2023-01-01",
            "endDate" => "2023-01-31",
            "capacity" => 20
        ]);

        $lessonController->create();

        $bookingsController = new BookingController((object)[
            "name" => "Pedro",
            "date" => "2023-01-01"]
        );

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"data":{"name":"Pedro","date":"2023-01-01"}}');

        $bookingsController = new BookingController((object)[
            "name" => "Pedro",
            "date" => "2024-01-01"]
        );

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"No class availlable at date 2024-01-01"}');

        $this->emptyDb();

        $bookingsController = new BookingController((object)[
            "name" => "Pedro",
            "date" => "2023-01-01"]
        );

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"No class availlable at date 2023-01-01"}');

        $bookingsController = new BookingController((object)[
            "name" => "Pedro",
            "date" => "2023-01-01"]
        );

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"No class availlable at date 2023-01-01"}');

        $lessonController->create();

        $bookingsController = new BookingController((object)[
            "date" => "2023-01-01"]
        );

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property name"}');

        $bookingsController = new BookingController((object)[
            "name" => "Pedro"]
        );

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property date"}');

        $bookingsController = new BookingController((object)[
            "name" => 11,
            "date" => "2023-01-01"]
        );

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Property name has to be of type string but has type integer"}');

        $bookingsController = new BookingController((object)[
            "name" => "pedro",
            "date" => "2021-01-01"]
        );

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"booking date is prior to today"}');

        $this->emptyDb();
    }

    private function emptyDb(): void
    {
        file_put_contents('/Users/palexaso/Sites/glfxmsp/Db.json', json_encode(["Lessons" => [], "Bookings" => []]));
    }   
}
