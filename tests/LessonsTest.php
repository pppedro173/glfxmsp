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

        $this->emptyDb();
    }

    public function testLessonsCreateFailures()
    {
        $bookingsController = new LessonController(null);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Empty request"}');

        $bookingsController = new LessonController((object)[]);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property name"}');

        $bookingsController = new LessonController((object)["name" => "pedro"]);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property startDate"}');

        $bookingsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-22"
        ]);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property endDate"}');

        $bookingsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-22",
            "endDate" => "2023-02-22"
        ]);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property capacity"}');

        $bookingsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-22",
            "endDate" => "2023-02-22",
            "capacity" => "bananas"
        ]);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Property capacity has to be of type integer but has type string"}');

        $bookingsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-22",
            "endDate" => "2023-01-21",
            "capacity" => 10
        ]);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"end date is prior to starting date"}');

        $bookingsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-01",
            "endDate" => "2023-01-21",
            "capacity" => -1
        ]);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"Invalid capacity"}');

        $bookingsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2021-01-22",
            "endDate" => "2023-01-21",
            "capacity" => 11
        ]);

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"starting date is prior to today"}');

        $bookingsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-01",
            "endDate" => "2023-01-21",
            "capacity" => 11
        ]);

        $bookingsController->create();

        $response = $bookingsController->create();

        $this->assertEquals($response, '{"error":"You cant select a date range with allready booked classes in it."}');

        $this->emptyDb();
    }

    private function emptyDb()
    {
        file_put_contents('/Users/palexaso/Sites/glfxmsp/Db.json', json_encode(["Lessons" => [], "Bookings" => []]));
    }
    
}
