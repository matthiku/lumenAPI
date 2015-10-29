<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class Controller extends BaseController
{


    // provide a generic responder for succesful API calls
    public function createSuccessResponse($data, $rc) {

        return response()->json(['data' => $data], $rc);
    }



    // provide a generic responder for failed API calls
    public function createErrorResponse($message, $rc) {

        return response()->json(['message' => $message, 'code' => $rc], $rc);
    }



    // we need to modify the default method in order to always return a code and a JSON formatted response
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        return $this->createErrorResponse($errors, 422);
    }

}
