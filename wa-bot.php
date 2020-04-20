<?php

require_once './vendor/autoload.php';

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Twilio\Rest\Client;

DriverManager::loadDriver(\FilippoToso\BotMan\Drivers\RocketChat\RocketChatDriver::class);
$botman = BotManFactory::create($config);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sid = getenv('TWILIO_ACCOUNT_SID');
$token = getenv('TWILIO_AUTH_TOKEN');
$twilio = new Client($sid, $token);

$codes = ["chocolate", "vanilla", "strawberry", "mint-chocolate-chip", "cookies-n-cream"];

$message = $twilio->messages
    ->create("whatsapp:".getenv("MY_WHATSAPP_NUMBER"),
        [
            "body" => "Your ice-cream code is ".$codes[rand(0,4)],
            "from" => "whatsapp:".getenv("TWILIO_WHATSAPP_NUMBER")
        ]
    );

print($message->sid);
