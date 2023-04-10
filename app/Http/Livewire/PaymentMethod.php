<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PaymentMethod extends Component
{
    public function getDefaultPaymentMethodProperty(){
        return auth()->user()->defaultPaymentMethod();
    }
    public function addPaymentMethod($paymentMethod){
        auth()->user()->addPaymentMethod($paymentMethod);
        if(!auth()->user()->hasDefaultPaymentMethod()){
            auth()->user()->updateDefaultPaymentMethod($paymentMethod);
        }
    }

    public function deletePaymentMethods($paymentMethod){
        auth()->user()->deletePaymentMethod($paymentMethod);
    }

    public function render()
    {
        return view('livewire.payment-method',[
            'intent' => auth()->user()->createSetupIntent(),
            'paymentMethods' => auth()->user()->paymentMethods(),
        ]);

    }

    public function defaultPaymentMethod($paymentMethod){
        auth()->user()->updateDefaultPaymentMethod($paymentMethod);
    }
}
