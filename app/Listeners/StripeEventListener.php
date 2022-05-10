<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     *
     * @param  \Laravel\Cashier\Events\WebhookReceived  $event
     * @return void
     */
    public function handle(WebhookReceived $event)
    {
        Log::debug($event->payload['type']);
        Log::debug(json_encode($event->payload));

        if ($event->payload['type'] === 'customer.subscription.created'
        || $event->payload['type'] === 'customer.subscription.updated') {
            $customerId = $event->payload['data']['object']['customer'];
            try {
                $credits = (int)$event->payload['data']['object']['plan']['metadata']['credits'];
            }
            catch (\Exception $ex) {
                app('sentry')->captureException($ex);
                $credits = 20000;
            }
            $user = User::where('stripe_id', '=', $customerId)->first();
            if ($user) {
                Log::info($user->email.' had '.$user->credits.' credits and has now '.$credits.' credits');
                $user->credits = $credits;
                $user->save();
            }
        }
    }
}
