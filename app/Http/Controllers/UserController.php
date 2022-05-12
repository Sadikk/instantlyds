<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Get remaining credits
     * @response {"credits": "150"}
     */
    public function getRemainingCredits(Request $request) {
        return $this->makeResponse(
            $request,
            [
                'credits' => $request->user()->credits
            ]
        );
    }

    public function showSubscription(Request $request) {
        return Inertia::render('Subscription', [
            'subscribed' => $request->user()->subscribed(),
            'subscription' => $request->user()->subscription()
        ]);
    }
}
