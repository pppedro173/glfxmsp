<?php declare(strict_types=1);

namespace Tests;

use App\Controllers\LessonController;
use PHPUnit\Framework\TestCase;

class LessonsTest extends TestCase
{
    public function testGetClasses()
    {
        $lessonsController = new LessonController((object)[]);
        
        $file = file_get_contents('/Users/palexaso/Sites/glfxmsp/Db.json');
        
        $allData = json_decode($file, true);

        $lessonsDbData = json_encode(['data' => array_values($allData['Lessons'])]);

        $lessonsRequestData = $lessonsController->list();

        $this->assertEquals($lessonsRequestData, $lessonsDbData);
    }
    
}
