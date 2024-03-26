<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    function register( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'full_name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8'

        ] );

        if ( $validator -> fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );

        } else {
            $user = User::create( [
                'full_name' -> $request -> full_name,
                'email' -> $request -> email,
                'password' -> Hash::make( $request -> password ),
            ] );

            $token = $user -> createToken( $user -> email.'_Token' ) -> plainTextToken;

            return response()-> json( [
                'status' => 200,
                'username' => $user -> name,
                'token' => $token,
                'message' => 'Registered Successfully',
            ] );
        }
    }
}
