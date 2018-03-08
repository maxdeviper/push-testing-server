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
'VAPID' => array(
        'subject' => 'mailto:mxvmayaki@gmail.com',
        'publicKey' => 'BG6ChZkawbaTnO7YVltnGcMkkP-B4cWN4en2ZgP6aEoZUomRYHH1FNuasGIJ_laAGAa2Q6m7NMerllSywW-1nw4',
        'privateKey' => 'BChgLlEoDeBMt_V2tIAUoqG_ZWrHdgJ5RUNqpVDet7c', // in the real world, this would be in a secret file
    ),
);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods : GET,POST,PUT,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $webPush = new WebPush($auth);
    // if (is_array($subscriptions)){
        try{
            
            // foreach($subscriptions as $subscription){
                $res = $webPush->sendNotification(
                    $subscription['endpoint'],
                    $data["message"],
                    $subscription['key'],
                    $subscription['token'],
                    true
                );
                var_dump($res);
                // $webPush->flush();
            // }
        } catch( Exception $e){
            $webPush->flush();
        }
    // }else{
    //     echo "No subscriptions saved";
    // }
    
} else {
    echo "No Push message";
}