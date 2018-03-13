<?php

require_once __DIR__."/vendor/autoload.php";
use Minishlink\WebPush\WebPush;
// here I'll get the subscription endpoint in the POST parameters
// but in reality, you'll get this information in your database
// because you already stored it (cf. push_subscription.php)
$subscription = json_decode(file_get_contents(__DIR__.'/user-subscription.json'), true);

$data = json_decode(file_get_contents('php://input'), true);
// die(var_dump($subscriptions));
$auth = array(
    'messagingServerKey' => "Your server Api token"
);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods : GET,POST,PUT,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try{
        $fcmPush = new FcmPusher($auth);
        
        $res = $fcmPush->push(
        $data,
        $subscription['token']
        );
        echo $res->getBody();
    }catch(Exception $e){
        print_r($e);
        file_put_contents(__DIR__."/push.log",$e->getResponse()->getBody()->getContents());
    }
    
} else {
    echo "No Push message";
}