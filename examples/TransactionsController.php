<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentCard;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    public function transactionsWithTryCatch($id_payment){
      DB::beginTransaction();
      try {
        $payment = Payment::find($id_payment);
        $payment->id_status = 13;
        $payment->save();
        $card_payment = PaymentCard::find($payment->id_card_payment);
        $card_payment->id_status = 25;
        $card_payment->save();
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
      }
    }
    public function implicitTransactions($id_payment){
      $payment = Payment::findOrFail($id_payment);
      $payment->id_status = 13;
      $payment->saveOrFail();
    }
}
