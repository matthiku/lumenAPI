<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Course;

class CourseController extends Controller
{



    // show all courses
    public function index() {

        $courses = Course::all();

    	return $this->createSuccessResponse( $courses, 200 );
    }



    // show a specific course
    public function show( $id ) {

        $course = Course::find($id);

        if ($course) {
            return $this->createSuccessResponse( $course, 200 );
        }

        return $this->createErrorResponse("The course with id {$id} does not exist", 404);
    }


}
