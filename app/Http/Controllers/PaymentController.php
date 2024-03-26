<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller {

    function addPayment( Request $req ) {

        $validator = Validator::make( $req -> all(), [
            'credit' => 'required|max:191',
            'debit' => 'required|max:191',
            'date' => 'required|max:191',
        ] );

        if ( $validator->fails() ) {
            return response()-> json( [
                'validation_errors' => $validator -> messages(),
            ] );
        } else {
            $payment =  new Payment;
            $payment -> credit = $req -> input( 'credit' );
            $payment -> debit = $req -> input( 'debit' );
            $payment -> date = $req -> input( 'date' );

            $payment -> save();
            return response() -> json( [
                'status' => 200,
                'message' => 'Payment Added Successfully'
            ] );
        }
    }

    function paymentList() {
        $payment = Payment::all();
        return response()-> json( [
            'status'=>200,
            'payment'=>$payment,
        ] );
    }
}
