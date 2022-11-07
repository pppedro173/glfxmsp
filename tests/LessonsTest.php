<?php declare(strict_types=1);

namespace Tests;

use App\Controllers\LessonController;
use PHPUnit\Framework\TestCase;

class LessonsTest extends TestCase
{
    public function testGetClassesError(): void
    {
        $this->emptyDb();

        $lessonsController = new LessonController((object)[]);

        $response = $lessonsController->list();

        $this->assertEquals($response, '{"error":"Lessons not found."}');
    }

    public function testCreateLessons(): void
    {
        $lessonsController = new LessonController((object)[
            "name" => "zumba",
            "startDate" => "2023-01-01",
            "endDate" => "2023-01-31",
            "capacity" => 20
        ]);

        $response = $lessonsController->create();

        $db = $lessonsController->list();

        $this->assertEquals($response, $db);
    }

    public function testLessonsCreateFailures(): void
    {
        $lessonsController = new LessonController(null);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"Empty request"}');

        $lessonsController = new LessonController((object)[]);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property name"}');

        $lessonsController = new LessonController((object)["name" => "pedro"]);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property startDate"}');

        $lessonsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-22"
        ]);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property endDate"}');

        $lessonsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-22",
            "endDate" => "2023-02-22"
        ]);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"Request is missing property capacity"}');

        $lessonsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-22",
            "endDate" => "2023-02-22",
            "capacity" => "bananas"
        ]);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"Property capacity has to be of type integer but has type string"}');

        $lessonsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-22",
            "endDate" => "2023-01-21",
            "capacity" => 10
        ]);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"end date is prior to starting date"}');

        $lessonsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-01",
            "endDate" => "2023-01-21",
            "capacity" => -1
        ]);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"Invalid capacity"}');

        $lessonsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2021-01-22",
            "endDate" => "2023-01-21",
            "capacity" => 11
        ]);

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"starting date is prior to today"}');

        $lessonsController = new LessonController((object)[
            "name" => "pedro",
            "startDate" => "2023-01-01",
            "endDate" => "2023-01-21",
            "capacity" => 11
        ]);

        $lessonsController->create();

        $response = $lessonsController->create();

        $this->assertEquals($response, '{"error":"You cant select a date range with allready booked classes in it."}');

        $this->emptyDb();
    }

    private function emptyDb(): void
    {
        file_put_contents(dirname(__DIR__, 1) .'/Db.json', json_encode(["Lessons" => [], "Bookings" => []]));
    }
    
}
