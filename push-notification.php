<?php

require_once __DIR__."/vendor/autoload.php";
use Minishlink\WebPush\WebPush;
// here I'll get the subscription endpoint in the POST parameters
// but in reality, you'll get this information in your database
// because you already stored it (cf. push_subscription.php)
$subscriptions = json_decode(file_get_contents(__DIR__.'/user-subscription.json'), true);

$data = json_decode(file_get_contents('php://input'), true);
$auth = array(
'VAPID' => array(
    'subject' => 'mailto:mxvmayaki@gmail.com',
    'publicKey' => 'BDtooTHUA8tx2p8Gi_iAKgsDfCilG-GosX7HGSlvGTp7RZEAX91MOztwWgLC3414tNrah5bJHMhcoNVVH9w4wBk',
    'privateKey' => 'HJweeF64L35gw5YLECa-K7hwp3LLfcKtpdRNK8C_fPQ', // in the real world, this would be in a secret file
    ),
);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods : GET,POST,PUT,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $webPush = new WebPush($auth);
    if (is_array($subscriptions)){
        try{
            
            foreach($subscriptions as $subscription){
                $res = $webPush->sendNotification(
                $subscription['endpoint'],
                $data["message"],
                $subscription['key'],
                $subscription['token'],
                true
                );
                var_dump($res["message"]);
                $webPush->flush();
            }
        } catch( Exception $e){
            $webPush->flush();
        }
    }else{
        echo "No subscriptions saved";
    }
    
}else{
    echo "No Push message";
}