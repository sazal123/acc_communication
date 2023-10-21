<?php

namespace App\Http\Controllers\Messenger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class FacebookWebhookController extends Controller
{
    private $appId = '990536575581468';
    private $appSecret = '70162ee7748470487ec99982d0e8aaa5';
    private $userToken = 'EAAOE40S5fRwBO6sZABPlJNH8QdZC9yMOEhqjCFQvrv3oBSZBUPTYfmF3Nun2ZCw5RlZArSB0O71mOEMV7N6HxVYwMYd6Cx8YPgwa5jN0aZBXh1m2dFFhRZCxYpNU3YtfDHTJcTHPyGZB7YGZA6PoYto5Nn4AwS2zZBhxFZByDhNNjXNuZCo1OdKpkwU7shTP';

    public function verifyWebhook(Request $request)
    {
        $verify_token = 'sazal'; // replace with your own token
        $mode = $request->get('hub_mode');
        $token = $request->get('hub_verify_token');
        $challenge = $request->get('hub_challenge');

        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $verify_token) {
                return response($challenge, 200);
            } else {
                return response('Forbidden', 403);
            }
        }
    }

    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        Log::info('Facebook Webhook Data: ', $data);

        $messaging = $request->input('entry.0.messaging.0');
        if (isset($messaging['message']['attachments'])) {
            foreach ($messaging['message']['attachments'] as $attachment) {
                $type = $attachment['type'];
                $url = $attachment['payload']['url'];
                Log::info("Received a $type attachment with URL: $url");
            }
        }

        return response('Event received', 200);
    }



    public function getConversationsList(Request $request)
    {
        $client = new Client();
        $response = $client->get("https://graph.facebook.com/2975105712621506/accounts", [
            'query' => [
                'access_token' => $this->userToken
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $page_access_token=$data['data'][0]['access_token'];
    }
}
