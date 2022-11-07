<?php declare(strict_types=1);

namespace Tests;

use App\Controllers\BookingController;
use PHPUnit\Framework\TestCase;

class BookingsTest extends TestCase
{
    public function testGetBookingsError()
    {
        $bookingsController = new BookingController((object)[]);
                
        $response = $bookingsController->list();

        $this->assertEquals($response, '{"error":"bookings not found."}');
    }

    private function emptyDb()
    {
        file_put_contents('/Users/palexaso/Sites/glfxmsp/Db.json', json_encode(["Lessons" => [], "Bookings" => []]));
    }   
}
