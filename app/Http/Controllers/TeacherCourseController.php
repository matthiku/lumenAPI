<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Teacher;

class TeacherCourseController extends Controller
{



    // show teacher of a certain course
    //
    public function index( $teacher_id ) {

        $teacher = Teacher::find($teacher_id);

        if ($teacher) {
            
            $result = $teacher->courses;
            return $this->createSuccessResponse( ['data' => $result], 200);
        }

        return $this->createErrorResponse("The teacher with id {$teacher_id} does not exist", 404);
    }



    //
    public function store() {
    	return __METHOD__;
    }


    //
    public function update() {
    	return __METHOD__;
    }


    //
    public function destroy() {
    	return __METHOD__;
    }

}
