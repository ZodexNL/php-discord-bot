<?php

include __DIR__ . '/vendor/autoload.php';
include './Includes.php';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Dotenv\Dotenv;
use src\Handlers\MessageHandler;

$dotEnv = Dotenv::createImmutable(__DIR__)->load();

$discord = new Discord([
    'token' => $_ENV['BOT_TOKEN'],
    'intents' => Intents::getDefaultIntents()
]);


$discord->on('ready', function (Discord $discord) {
    $msgListener = new MessageHandler;
    echo "Bot is ready!", PHP_EOL;

    // Listen for messages.
    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) use ($msgListener) {
        // Handle the message
        $msgListener->handle($message, $discord);
        echo ' msg handled ';

        echo "{$message->author->username}: {$message->content}", "{$message->channel}", PHP_EOL;
    });
});

$discord->run();
