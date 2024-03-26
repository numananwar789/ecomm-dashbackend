<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {

    function addProduct( Request $req ) {

        $validator = Validator::make( $req -> all(), [
            'name' => 'required|max:191',
        ] );

        if ( $validator->fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );
        } else {
            $product =  new Product;
            $product -> name = $req -> input( 'name' );
            $product -> save();
            return response() -> json( [
                'status' => 200,
                'message' => 'Product Added Successfully'
            ] );
        }
    }

    function list() {
        $products = Product::all();
        return response()-> json( [
            'status'=>200,
            'products'=>$products,
        ] );
    }

    function getProduct( $id ) {
        return Product::find( $id );
    }

    function updateProduct( $id, Request $req ) {

        $product =  Product::find( $id );
        $product -> name = $req -> input( 'name' );
        $product -> type = $req -> input( 'type' );
        $product -> price = $req -> input( 'price' );
        $product -> quantity = $req -> input( 'quantity' );

        $product->save();

        return $product;
    }

    function search( $key ) {
        return Product::where( 'name', 'like', "%$key%" ) -> get();
    }

}

