<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Description;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class DescriptionController extends Controller {
    //

    function addDescription ( Request $req ) {
        //
        $validator = Validator::make( $req -> all(), [
            'product_id' => 'required',
            'type' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ] );

        if ( $validator->fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );
        } else {
            $description =  new Description;
            $description -> product_id = $req -> input( 'product_id' );
            $description -> type = $req -> input( 'type' );
            $description -> quantity = $req -> input( 'quantity' );
            $description -> price = $req -> input( 'price' );
            $description -> save();
            return response() -> json( [
                'status' => 200,
                'message' => 'Product Description Added Successfully'
            ] );
        }
    }

    function descriptionList() {
        $description = Description::all();
        return response()-> json( [
            'status'=>200,
            'description'=>$description,
        ] );
    }

    function getDescription( $id ) {
        $description = Description::find( $id );
        if ( $description ) {
            return response()-> json( [
                'status'=>200,
                'description'=>$description,
            ] );
        } else {
            return response()-> json( [
                'status'=>404,
                'message'=>'No description found',
            ] );
        }

    }

    function updateDescription( $id, Request $req ) {
        $validator = Validator::make( $req -> all(), [
            'product_id' => 'required',
            'type' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ] );

        if ( $validator->fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );
        } else {
            $description =  Description::find( $id );
            if ( $description ) {

                $description -> product_id = $req -> input( 'product_id' );
                $description -> type = $req -> input( 'type' );
                $description -> quantity = $req -> input( 'quantity' );
                $description -> price = $req -> input( 'price' );
                $description -> update();

                return response() -> json( [
                    'status' => 200,
                    'message' => 'Product Description Updated Successfully'
                ] );
            } else {

                return response() -> json( [
                    'status' => 404,
                    'message' => 'Product Description Not Found'
                ] );
            }
        }
    }

    function delete( $id ) {
        $result = Description::find( $id );
        $result -> delete();

        // $result = DB::table( 'products' )->where( 'product_id', $id )->delete();

        if ( $result ) {

            return response()-> json( [
                'status'=>200,
                'message'=>'Product Deleted Successfully',
            ] );
            // return ['result'=>'product has been deleted'];
        } else {
            return response()-> json( [
                'status'=>404,
                'message'=>'No Product ID Found.',
            ] );
            // return ['result'=>'Operation Failed!'];
        }
    }
}
