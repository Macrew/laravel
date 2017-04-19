<?php 

namespace App\Devartisans\Subscriber;

use Mailchimp as ListProvider;
use Illuminate\Http\Request;
use Validator;
use App\User;

class Mailchimp {

	protected $mailchimp;
	protected $listener;
	protected $listid;

	public function __construct($listener)
	{
		$this->mailchimp = new ListProvider(getenv('MAILCHIMP_API_KEY'));
		$this->listid = getenv('MAILCHIMP_LIST_ID');
		$this->listener = $listener;

	}

	public function saveNewSubscriber(array $data )
	{
		return User::create([ 'email' => $data['email'] ]);
	}

	protected function validate(Request $request)
	{
		return Validator::make($request->all(), [
			'email' => 'required|email|max:255|unique:users'
			]);
	}

	public function subscribe(Request $request)
	{
	//echo $request->get('email');

			$addedToProviderList = $this->subscribeToList($request->get('email'));
			if($addedToProviderList['status'] == 'Success')
			{
				return $this->listener->subscription_succeed($addedToProviderList['msg']);
			} elseif($addedToProviderList['status'] == 'Exist') {
			return $this->listener->subscription_failed($addedToProviderList['msg']);
			} else {
			return $this->listener->subscription_failed($addedToProviderList['msg']);
			}
	/* 	if ($this->validate($request)->fails())
		{
			return $this->listener->subscription_failed('You have already subscribed to our mailing list');
		}
		$addedToProviderList = $this->subscribeToList($request->get('email'));
			
			if($addedToProviderList)
			{
				return $this->listener->subscription_succeed('Thank you for subscribing');
			} */

		//$subscriberAdded = $this->saveNewSubscriber($request->all());

		/* if( $subscriberAdded )
		{
			$addedToProviderList = $this->subscribeToList($request->get('email'));
			
			if($addedToProviderList)
			{
				return $this->listener->subscription_succeed('Thank you for subscribing');
			}
		} */


	}

	public function subscribeToList($email)
	{
	
		$result = $this->mailchimp->lists->subscribe(
				$this->listid,
				compact('email'),
                null, // merge vars
                'html', // email type
                false, // requires double optin
                false, // update existing members
                true
                );

		if(!empty($result['email']) && !empty($result['euid']))
		{
			$status = 'Success';
			$msg = array('status'=>$status,'msg'=>'Thank you for subscribing');
			return $msg;
		}
		else if(!empty($result['status']) && $result['status'] === 'error' && !empty($result['name'] && $result['code'] == '214'))
		{
			$status = 'Exist';
			$msg = array('status'=>$status,'msg'=>$result['error']);
			return $msg;
		}
		else {
			$status = 'Unexpected Error';
			$msg = array('status'=>$status,'msg'=>'We have received an unexpected error.');
			return $status;
		}
	
		/* try {
			$status = $this->mailchimp->lists->subscribe(
				$this->listid,
				compact('email'),
                null, // merge vars
                'html', // email type
                false, // requires double optin
                false, // update existing members
                true
                );
				
			

		}
		catch(Exception $e)
		{
			return false;
            // if 214 then already subscribed
            //var_dump($e->getCode());
		} */
	}

	public function unsubscribeFromList($email)
	{
		return $this->mailchimp->lists->unsubscribe(
			$this->listid,
			compact('email'),
            false, //delete permanently
            false, //send goodbye emails
            false //send unsubscribe notification email
            );
	}

	public function sendCampaign(array $data)
	{
		$html = $data['body'];
		$options = [
		'list_id'   => $this->listid,
		'subject' => $data['subject'],
		'from_name' => $data['mail_from'],
		'from_email' => 'vikash.t@macrew.net',
		'to_name' => $data['mail_to']
		];

		$content = [
		'html' => $html,
		'text' => strip_tags($html)
		];

		$campaign = $this->mailchimp->campaigns->create('regular', $options, $content);
		return $this->mailchimp->campaigns->send($campaign['id']);
	}

}