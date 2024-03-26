<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller {
    //

    function addStock( Request $req ) {

        $validator = Validator::make( $req -> all(), [
            'stock_received' => 'required|max:191',
            'stock_returned' => 'required|max:191',
            'stock_in_hand' => 'required|max:191',
            'stock_price' => 'required|max:191',
            'date' => 'required|max:191',
        ] );

        if ( $validator->fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );
        } else {
            $stock =  new Stock;
            $stock -> stock_received = $req -> input( 'stock_received' );
            $stock -> stock_returned = $req -> input( 'stock_returned' );
            $stock -> stock_in_hand = $req -> input( 'stock_in_hand' );
            $stock -> stock_price = $req -> input( 'stock_price' );
            $stock -> date = $req -> input( 'date' );

            $stock -> save();
            return response() -> json( [
                'status' => 200,
                'message' => 'Stock Added Successfully'
            ] );
        }
    }

    function stockList() {
        $stock = Stock::all();
        return response()-> json( [
            'status'=>200,
            'stock'=>$stock,
        ] );
    }

    function getStock( $id ) {
        $stock = Stock::find( $id );
        if ( $stock ) {
            return response()-> json( [
                'status'=>200,
                'stock'=>$stock,
            ] );
        } else {
            return response()-> json( [
                'status'=>404,
                'message'=>'No Stock ID found',
            ] );
        }
    }

    function updateStock( $id, Request $req ) {
        $validator = Validator::make( $req -> all(), [
            'stock_received' => 'required',
            'stock_returned' => 'required',
            'stock_in_hand' => 'required',
            'stock_price' => 'required',
            'date' => 'required',
        ] );

        if ( $validator->fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );
        } else {
            $stock =  Stock::find( $id );
            if ( $stock ) {

                $stock -> stock_received = $req -> input( 'stock_received' );
                $stock -> stock_returned = $req -> input( 'stock_returned' );
                $stock -> stock_in_hand = $req -> input( 'stock_in_hand' );
                $stock -> stock_price = $req -> input( 'stock_price' );
                $stock -> date = $req -> input( 'date' );
                $stock -> update();

                return response() -> json( [
                    'status' => 200,
                    'message' => 'Stock Updated Successfully'
                ] );
            } else {

                return response() -> json( [
                    'status' => 404,
                    'message' => 'Stock Not Found'
                ] );
            }
        }
    }

    function deleteStock( $id ) {
        $result = Stock::find( $id );
        $result -> delete();

        // $result = DB::table( 'products' )->where( 'product_id', $id )->delete();

        if ( $result ) {

            return response()-> json( [
                'status'=>200,
                'message'=>'Stock Deleted Successfully',
            ] );
            // return ['result'=>'product has been deleted'];
        } else {
            return response()-> json( [
                'status'=>404,
                'message'=>'No Stock ID Found.',
            ] );
            // return ['result'=>'Operation Failed!'];
        }
    }
}
