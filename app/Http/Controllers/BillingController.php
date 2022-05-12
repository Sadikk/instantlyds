<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class BillingController extends Controller
{
    /**
     *
     */
    public function subscriptionCheckout(Request $request)
    {
        $request->validate([
            'prod' => 'required|string',
            'price' => 'required|string',
            'ref' => 'nullable|string'
        ]);
        $product_id = $request->input('plan');
        $price_id = $request->input('price');
        $ref = $request->input('ref', 'noref');
        if (empty($ref)) {
            $ref = 'noref';
        }
        return $request->user()
            ->newSubscription($product_id, $price_id)
            //->trialDays(3)
            ->checkout([
                'client_reference_id' => $ref,
            ]);
    }

    public function billingPortal(Request $request) {
        return $request->user()->redirectToBillingPortal();
    }
}
