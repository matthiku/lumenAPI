<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Teacher;
use App\Course;

use Illuminate\Http\Request;


/* This controller deals with the following routes:

$app->get(    '/teachers/{teachers}/courses',           'TeacherCourseController@index');
$app->post(   '/teachers/{teachers}/courses',           'TeacherCourseController@store');
$app->put(    '/teachers/{teachers}/courses/{courses}', 'TeacherCourseController@update');
$app->patch(  '/teachers/{teachers}/courses/{courses}', 'TeacherCourseController@update');
$app->delete( '/teachers/{teachers}/courses/{courses}', 'TeacherCourseController@destroy');

*/


class TeacherCourseController extends Controller
{



    /* 
     * Show teacher of a certain course
     *
     * ROUTE: GET /teachers/{teachers}/courses
     */
    public function index( $teacher_id ) {

        $teacher = Teacher::find($teacher_id);

        if ($teacher) {
            
            $result = $teacher->courses;
            return $this->createSuccessResponse( $result, 200);
        }

        return $this->createErrorResponse("The teacher with id {$teacher_id} does not exist", 404);
    }





    /*
     * Create a new course for a teacher
     *
     * ROUTE: POST /teachers/{teachers}/courses
     */
    public function store(Request $request, $teacher_id) {

        // check if teacher exists ...
        $teacher = Teacher::find($teacher_id);

        // ... then proceed ...
        if ($teacher) {

            // make sure the submitted fields are valid
            $this->validateRequest($request);

            // create a new course record
            $course = Course::create(
                [
                    'title'       => $request->get('title'),
                    'description' => $request->get('description'),
                    'value'       => $request->get('value'),
                    'teacher_id'  => $teacher_id
                ]
            );

            return $this->createSuccessResponse("The course with id {$course_id} has been created and associated with the teacher with id {$teacher_id}", 201);
        }

        return $this->createErrorResponse("The teacher with id {$teacher_id} does not exist", 404);
    }





    /*
     * Update an existing course
     *
     * ROUTE: POST /teachers/{teachers}/courses/{courses}
     */
    public function update(Request $request, $teacher_id, $course_id) {

        // check if teacher exists ...
        $teacher = Teacher::find($teacher_id);

        // ... then proceed ...
        if ($teacher) {

            $course = Course::find($course_id);

            if ($course_id) {

                // make sure the submitted fields are valid
                $this->validateRequest($request);

                    $course->title       = $request->get('title');
                    $course->description = $request->get('description');
                    $course->value       = $request->get('value');
                    $course->teacher_id  = $teacher_id;

                    $course->save();

                return $this->createSuccessResponse("The course with id {$course_id} has been updated and associated with the teacher with id {$teacher_id}", 200);
            }
            return $this->createErrorResponse("The course with id {$course_id} does not exist", 404);
        }
        return $this->createErrorResponse("The teacher with id {$teacher_id} does not exist", 404);
    }







    /*
     * DELETE an existing course
     *
     * ROUTE: DELETE /teachers/{teachers}/courses/{courses}
     */
    public function destroy($teacher_id, $course_id) {

        // check if teacher exists ...
        $teacher = Teacher::find($teacher_id);

        // ... then proceed ...
        if ($teacher) {

            $course = Course::find($course_id);

            if ($course) {

                // check if this course is actually associated with the teacher
                if ($teacher->courses()->find($course_id)) {

                    // first we need to remove the associated students from this course
                    $course->students()->detach();

                    // now remove the course
                    $course->delete();

                    return $this->createSuccessResponse("The course with id {$course_id} was deleted", 200);
                }

                return $this->createErrorResponse("The course with id {$course_id} is not associated with this teacher", 404);
                
            }
            return $this->createErrorResponse("The course with id {$course_id} does not exist", 404);
        }
        return $this->createErrorResponse("The teacher with id {$teacher_id} does not exist", 404);
    }




    // validate the fields received from the URL/POST methods
    function validateRequest($request) {
        $rules = 
        [
            'title'       => 'required',
            'description' => 'required',
            'value'       => 'required|numeric',
        ];        
        // if validation fails, it will produce an error response
        $this->validate($request, $rules);
    }



}
