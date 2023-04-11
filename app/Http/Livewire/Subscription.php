<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Subscription extends Component
{
    public function newSubscription($plan){
        //dd($plan);
        $stripe = new \Stripe\StripeClient(
            'sk_test_51LZk7pIouA9z8SYyfOAHSEm9opwyaipP01qRyhkiTnsw7Ue4a3GtNopuzDKyMzzrelXDmDEKcliXaSW0lI8f9euv00XJ8VrToP'
          );
          $subscripcion=$stripe->checkout->sessions->create([
            'customer' => ''.auth()->user()->stripe_id.'',
            'success_url' => 'http://subscripciones.test/billing',
            'line_items' => [
              [
                'price' => ''.$plan.'',
                'quantity' => 1,
              ],
            ],
            'mode' => 'subscription',
          ]);

          return redirect()->away(''.$subscripcion->url.'');
    }

    public function render()
    {
        return view('livewire.subscription');
    }
}
