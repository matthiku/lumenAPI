<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Course;
use App\Student;


/*
This controller deals with the following routes:

$app->get(    '/courses/{courses}/students',            'CourseStudentController@index');
$app->post(   '/courses/{courses}/students/{students}', 'CourseStudentController@store');
$app->delete( '/courses/{courses}/students/{students}', 'CourseStudentController@destroy');
*/

class CourseStudentController extends Controller
{





    /*
     * show all students taking a certain course
     *
     * ROUTE: GET /courses/{courses}/students
     */
   public function index( $course_id ) {

        $course = Course::find($course_id);

        if ($course) {

            $result = $course->students;
            return $this->createSuccessResponse( $result, 200);
        }

        return $this->createErrorResponse("The course with id {$course_id} does not exist", 404);
    }







    /*
     * add a student to a course
     *
     * ROUTE: POST /courses/{courses}/students/{students}
     */
    public function store($course_id, $student_id) {

        // check if the course exists
        $course = Course::find($course_id);

        if ($course) {

            // check if the student exists
            $student = Student::find($student_id);

            if ($student) {

                // first check if this student is not already in the list of students for this course
                if ($course->students()->find($student_id)) {
                    return $this->createErrorResponse("The student with id {$student_id} is already subscribed to this course", 409);
                }

                // add this student to the list of students of this course
                $course->students()->attach($student->id);

                return $this->createSuccessResponse("The student with id {$student_id} was added to this course", 201);
            }

            return $this->createErrorResponse("The student with id {$student_id} does not exist", 404);
        }

        return $this->createErrorResponse("The course with id {$course_id} does not exist", 404);
    }






    /*
     * remove a student from a course
     *
     * ROUTE: DELETE /courses/{courses}/students/{students}
     */
    public function destroy($course_id, $student_id) {

        // check if the course exists
        $course = Course::find($course_id);

        if ($course) {

            // check if the student exists
            $student = Student::find($student_id);

            if ($student) {

                // first check if this student is not already in the list of students for this course
                if (!$course->students()->find($student_id)) {
                    return $this->createErrorResponse("The student with id {$student_id} is not subscribed to this course", 404);
                }

                // remove this student from the list of students of this course
                $course->students()->detach($student->id);

                return $this->createSuccessResponse("The student with id {$student_id} has been removed from this course", 201);
            }

            return $this->createErrorResponse("The student with id {$student_id} does not exist", 404);
        }

        return $this->createErrorResponse("The course with id {$course_id} does not exist", 404);
    }

}

