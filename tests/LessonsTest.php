<?php declare(strict_types=1);

namespace Tests;

use App\Controllers\LessonController;
use PHPUnit\Framework\TestCase;

class LessonsTest extends TestCase
{
    public function testGetClasses()
    {
        $this->emptyDb();

        $lessonsController = new LessonController((object)[]);

        $response = $lessonsController->list();

        $this->assertEquals($response, '{"error":"Lessons not found."}');
    }

    public function testCreateLessons()
    {
        $bookingsController = new LessonController((object)[
            "name" => "zumba",
            "startDate" => "2023-01-01",
            "endDate" => "2023-01-31",
            "capacity" => 20
        ]);

        $response = $bookingsController->create();

        $db = $bookingsController->list();

        $this->assertEquals($response, $db);
    }

    public function testGetLessonsSuccess()
    {
        $bookingsController = new LessonController((object)[]);
                
        $response = $bookingsController->list();

        $file = file_get_contents('/Users/palexaso/Sites/glfxmsp/Db.json');
        $data = json_decode($file, true);

        $all = array_values($data['Lessons']);

        $this->assertEquals($response, json_encode(['data' => $all]));
    }

    public function testLessonsCreateFailures()
    {
        $bookingsController = new LessonController(null);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Empty request"}');

        $this->emptyDb();
    }

    private function emptyDb()
    {
        file_put_contents('/Users/palexaso/Sites/glfxmsp/Db.json', json_encode(["Lessons" => [], "Bookings" => []]));
    }
    
}
