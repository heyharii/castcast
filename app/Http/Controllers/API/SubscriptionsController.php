<?php

namespace Castcast\Http\Controllers\API;

use Illuminate\Http\Request;
use Castcast\Http\Controllers\Controller;

class SubscriptionsController extends Controller
{
    
    public function subscribe() {
       auth()->user()
                ->newSubscription(
                    request('plan'), request('plan')
                )->create(
                    request('stripeToken')
                );

         return response()->json(['success' => 'Plan has subscribe Successfully !'], 403);
    }

    public function change() {

        
        $this->validate(request(), [
            'plan' => 'required'
        ]);
        
        $user = auth()->user();
        $userPlan = $user->subscriptions->first();

        if (request('plan') === $userPlan->name) {
            return response()->json(['error' => 'You have subscribe this plan !'], 403);
        }
         
        if(request('plan')  === 'monthly'){
            
            $userPlan->name = 'monthly';
            $user->subscription($userPlan->name)->swap('plan_CYEYxtAbre39IO');
        }else{
             
             $userPlan->name = 'yearly';
             $user->subscription($userPlan->name)->swap('plan_CYEZiRkSDX2AwI');
        }
          return response()->json(['success' => 'Plan has change Successfully !'], 403);
    }
}
