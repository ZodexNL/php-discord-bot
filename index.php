<?php

include __DIR__ . '/vendor/autoload.php';
include './autoload.php';

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Interactions\Interaction;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Dotenv\Dotenv;
use src\Commands\Initialize\CreateAllCommands;
use src\Handlers\MessageHandler;

$dotEnv = Dotenv::createImmutable(__DIR__)->load();

$discord = new Discord([
    'token' => $_ENV['BOT_TOKEN'],
    'intents' => Intents::getDefaultIntents()
]);

$discord->on('ready', function (Discord $discord) {
    new CreateAllCommands($discord);
    $msgListener = new MessageHandler;
    echo "Bot is ready!", PHP_EOL;



    // Listen for messages.
    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) use ($msgListener) {
        // Handle the message
        $msgListener->handle($message, $discord);
    });


    // Listen for slash commands TODO: make commandhandler
    $discord->listenCommand('ping', function (Interaction $interaction) {
        $interaction->respondWithMessage(MessageBuilder::new()->setContent('Pong!'));
    });
});

$discord->run();
