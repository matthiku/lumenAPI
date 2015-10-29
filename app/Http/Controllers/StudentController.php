<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

// our data model
use App\Student;

// methods to access the http form data
use Illuminate\Http\Request;


class StudentController extends Controller
{



    // show all students
    public function index() {

        $result = Student::all();

        return $this->createSuccessResponse( $result, 200 );
    }




    // show a specific student
    public function show( $id ) {

        $result = Student::find($id);

        if ($result) {
            return $this->createSuccessResponse( $result, 200 );
        }

        return $this->createErrorResponse("The student with id {$id} does not exist", 404);
    }






    // create a new resource
    //
    public function store(Request $request) {

        $this->validateRequest($request);

        // create a new student record in the DB table and return a confirmation
        $student = Student::create($request->all());
        return $this->createSuccessResponse( "The student with id {$student->id} was created", 201 );
    }




    // UPDATE an existing resource
    //
    public function update(Request $request, $student_id) {

        $result = Student::find($student_id);

        if ($result) {

            $this->validateRequest($request);

            $result->name       = $request->name;
            $result->address    = $request->address;
            $result->phone      = $request->phone;
            $result->career     = $request->career;
            $result->save();

            return $this->createSuccessResponse( "The student with id {$result->id} was updated", 200 );
        }

        return $this->createErrorResponse("The student with id {$student_id} does not exist", 404);
    }





    // validate the fields received from the URL/POST methods
    function validateRequest($request) {
        $rules = 
        [
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required|numeric',
            'career'  => 'required|in:engineering,maths,physics'
        ];        
        // if validation fails, it will produce an error response }
        $this->validate($request, $rules);
    }






    // DELETE a resource
    public function destroy($student_id) {

        $student = Student::find($student_id);

        if ($student) {

            // FIRST, we need to remove this student from all his courses
            $student->courses()->detach();

            $student->delete();
            return $this->createSuccessResponse( "The student with id {$student->id} has been deleted", 200 );

        }

        return $this->createErrorResponse("The student with id {$student_id} does not exist", 404);
    }




}
