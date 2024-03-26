<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    function register( Request $req ) {

        $validator = Validator::make( $req ->all(), [
            'name' => 'required|max:191',
            'email' => 'required|max:191|email|unique:users,email',
            'password' => 'required|max:191'

        ] );

        if ( $validator -> fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );

        } else {

            $user = User::create( [
                'name'=>$req->name,
                'email'=>$req->email,
                'password'=>Hash::make( $req->password ),
            ] );

            $token = $user -> createToken( $user -> email.'_Token' ) -> plainTextToken;

            return response()->json( [
                'status' => 200,
                'username' => $user -> name,
                'token' => $token,
                'message' => 'Registered Successfully'
            ] );

        }

    }

    function login( Request $req ) {

        $validator = Validator::make( $req ->all(), [
            'email' => 'required|max:191',
            'password' => 'required'

        ] );

        if ( $validator -> fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );

        } else {

            $user = User::where( 'email', $req -> email ) -> first();

            if ( !$user || !Hash::check( $req -> password, $user -> password ) ) {
                return response()->json( [
                    'status' => 401,
                    'message' => 'Invalid Credentials'
                ] );
            } else {

                $token = $user -> createToken( $user -> email.'_Token', [''] ) -> plainTextToken;
                // session( ['name'=>$user -> name, 'admin_id'=> $user -> id] );
                // $req ->session()->flash( 'msg_login', 'try again...' )
                return response()->json( [
                    'status' => 200,
                    'username' => $user -> name,
                    'token' => $token,
                    'message' => 'Logged in Successfully'
                ] );
            }
        }
    }

    public function logout() {
        // session()->flush();
        auth()->user()->tokens()->delete();
        return response() -> json( [
            'status' => 200,
            'message' => 'Logged Out Successfully',
        ] );
    }
}
