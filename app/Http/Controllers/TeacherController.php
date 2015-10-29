<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Teacher;

use Illuminate\Http\Request;


class TeacherController extends Controller
{



    // show all teachers
    public function index() {

        $result = Teacher::all();

        return $this->createSuccessResponse( $result, 200 );
    }





    // show a specific teacher
    //
    public function show( $id ) {

        $result = Teacher::find($id);

        if ($result) {
            return $this->createSuccessResponse( $result, 200 );
        }

        return $this->createErrorResponse("The teacher with id {$id} does not exist", 404);
    }





    // create a new resource
    //
    public function store(Request $request) {

        $this->validateRequest($request);

        // create a new teacher record in the DB table and return a confirmation
        $teacher = Teacher::create($request->all());
    	return $this->createSuccessResponse( "The teacher with id {$teacher->id} was created", 201 );
    }






    // UPDATE an existing resource
    //
    public function update(Request $request, $teacher_id) {

        $result = Teacher::find($teacher_id);

        if ($result) {

            $this->validateRequest($request);

            $result->name       = $request->name;
            $result->address    = $request->address;
            $result->phone      = $request->phone;
            $result->profession = $request->profession;
            $result->save();

            return $this->createSuccessResponse( "The teacher with id {$result->id} was updated", 200 );
        }

        return $this->createErrorResponse("The teacher with id {$teacher_id} does not exist", 404);
    }






    // validate the fields received from the URL/POST methods
    function validateRequest($request) {
        $rules = 
        [
            'name'       => 'required',
            'address'    => 'required',
            'phone'      => 'required|numeric',
            'profession' => 'required|in:engineering,maths,physics'
        ];        
        // if validation fails, it will produce an error response }
        $this->validate($request, $rules);
    }





    // DELETE a resource
    public function destroy($teacher_id) {

        $teacher = Teacher::find($teacher_id);

        if ($teacher) {

            // FIRST, we need to make sure this teacher has no courses any more
            $courses = $teacher->courses;

            if (sizeof($courses) > 0) {
                return $this->createErrorResponse("The teacher with id {$teacher_id} still owns courses and can not be deleted!", 409);
            }

            $teacher->delete();
            return $this->createSuccessResponse( "The teacher with id {$teacher->id} has been deleted", 200 );

        }

        return $this->createErrorResponse("The teacher with id {$student_id} does not exist", 404);
    }


}
