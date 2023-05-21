<?php

include __DIR__ . '/vendor/autoload.php';
include './autoload.php';

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
    // Create all commands
    $commands = new CreateAllCommands($discord, false);
    // Initialize mesage listener
    $msgListener = new MessageHandler;

    // Bot is ready
    echo "Bot is ready!", PHP_EOL;

    // Listen for messages.
    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) use ($msgListener) {
        // Handle the message
        $msgListener->handle($message, $discord);
    });

    // Listen for commands
    foreach ($commands->cmdNameArr as $key => $value) {
        $discord->listenCommand($key, function (Interaction $interaction) use ($key, $value) {
            $value::getResponse($interaction);
        });
    }
});

$discord->run();
