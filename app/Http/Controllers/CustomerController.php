<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {
    //

    function register( Request $req ) {

        $validator = Validator::make( $req ->all(), [
            'name' => 'required|max:191',
            'email' => 'required|max:191|email|unique:customers,email',
            'address' => 'required|max:191',
            'password' => 'required|max:191'

        ] );

        if ( $validator -> fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );

        } else {

            $customer = Customer::create( [
                'name'=>$req->name,
                'email'=>$req->email,
                'address'=>$req->address,
                'password'=>Hash::make( $req->password ),
            ] );

            return response()->json( [
                'status' => 200,
                'username' => $customer -> name,
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

            $customer = Customer::where( 'email', $req -> email ) -> first();

            if ( !$customer || !Hash::check( $req -> password, $customer -> password ) ) {
                return response()->json( [
                    'status' => 401,
                    'message' => 'Invalid Credentials'
                ] );
            } else {

                // session( ['name'=>$user -> name, 'admin_id'=> $user -> id] );
                // $req ->session()->flash( 'msg_login', 'try again...' )
                return response()->json( [
                    'status' => 200,
                    'username' => $customer -> name,
                    'message' => 'Logged in Successfully'
                ] );
            }
        }
    }

    function customerList() {
        $customer = Customer::all();
        return response()-> json( [
            'status'=>200,
            'customer'=>$customer,
        ] );
    }

    function deleteCustomer( $id ) {
        $result = Customer::find( $id );
        $result -> delete();

        if ( $result ) {

            return response()-> json( [
                'status'=>200,
                'message'=>'Customer Deleted Successfully',
            ] );
            // return ['result'=>'Customer has been deleted'];
        } else {
            return response()-> json( [
                'status'=>404,
                'message'=>'No Customer ID Found.',
            ] );
            // return ['result'=>'Operation Failed!'];
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
