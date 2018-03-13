<?php

use GuzzleHttp\Client;

class FcmPusher{
    private $fcmBaseUrl = 'https://fcm.googleapis.com/fcm/send';
    private $auth = null;
    private $httpClient;
    public function __construct($auth=[]) {
        if (array_key_exists('messagingServerKey', $auth) && !empty($auth['messagingServerKey']) ){
            
            $this->auth = $auth["messagingServerKey"];
        }
        $this->httpClient = new Client();
    }
    /**
    * Send Message to client
    *
    * @return boolean
    */
    public function push($message, $toClient, array $withOptions = []) {
        return $this->httpClient->request('POST', $this->fcmBaseUrl, [
          'json' =>['notification' => $message, 'to' => $toClient],
          'headers' => [
            'Authorization' => sprintf('key=%s', $this->auth),
          ]
        ]);
    }
    
}