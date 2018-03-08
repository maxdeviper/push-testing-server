<?php

require_once __DIR__."/vendor/autoload.php";
use Minishlink\WebPush\WebPush;

echo json_encode(\Minishlink\WebPush\VAPID::createVapidKeys());