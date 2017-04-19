<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Devartisans\Subscriber\Mailchimp as SubscriptionHandler;
class SubscriptionController extends Controller
{
	protected $subscriptionHandler;

	public function __construct()
	{
		$this->subscriptionHandler = new SubscriptionHandler($this);
	}

	public function subscribe( Request $request )
	{
		return $this->subscriptionHandler->subscribe($request);
	}

	public function subscription_failed($message )
	{
		return $message;
	}

	public function subscription_succeed( $message )
	{
		return $message;
	}

	public function createCampaign(Request $request)
	{
		return view('subscription.create');
	}
	public function sendCampaign(Request $request)
	{
		$status = $this->subscriptionHandler->sendCampaign($request->all());

		if(! $status)
		{
			return redirect()->back()->with('message', 'Could not send campaign');
		}
		return redirect()->back()->with('message', 'campaign sent successfully');

	}
}