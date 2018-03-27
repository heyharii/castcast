<?php

namespace Castcast\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function showSubscriptionForm() {
        return view('subscribe');
    }
    
    public function subscribe() {
        return auth()->user()
                ->newSubscription(
                    request('name'), request('plan')
                )->create(
                    request('stripeToken')
                );
    }

    public function change() {

        
        $this->validate(request(), [
            'plan' => 'required'
        ]);
        
        $user = auth()->user();
        $userPlan = $user->subscriptions->first();

        if (request('plan') === $userPlan->name) {
            return redirect()->back();
        }
         
        if(request('plan')  === 'monthly'){
            
            $userPlan->name = 'monthly';
            $user->subscription($userPlan->name)->swap('plan_CYEYxtAbre39IO');
        }else{
             
             $userPlan->name = 'yearly';
             $user->subscription($userPlan->name)->swap('plan_CYEZiRkSDX2AwI');
        }
        return redirect()->back();
    }
}
