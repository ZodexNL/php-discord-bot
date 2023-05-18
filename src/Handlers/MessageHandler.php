<?php

namespace src\Handlers;

use Discord\Discord;
use Discord\Parts\Channel\Message;
// TODO: find a way to use all cmds
use src\Messages\Ping;

class MessageHandler
{
    public $commands = [];


    public function __construct()
    {
        $this->commands = $this->getAllCommands();
    }

    /**
     * Return the commands
     * 
     * @return array
     */
    private function getAllCommands(): array
    {
        $cmds = [];
        $files = array_diff(scandir('src/Messages/'), array('..', '.'));

        foreach ($files as $file) {
            $cmdName = strtolower(pathinfo($file, PATHINFO_FILENAME));
            array_push($cmds, $cmdName);
        }

        return $cmds;
    }

    /**
     * @param Message $message 
     * @param Discord $discord 
     * @return void 
     */
    public function handle(Message $message, Discord $discord): void
    {
        // TODO: make a seperate file that can handle more checks

        if ($message->author->bot === true) {
            return;
        }

        $msg = $message->content;
        // TODO: improve so that the needle must have whitespace
        foreach ($this->commands as $cmd) {
            if (str_contains($msg, $cmd)) {
                // TODO: improve this (maybe use array with raw class locations)

                // it works but ugly (To improve)
                $val = "src\Messages\\" . ucfirst($cmd);
                $val::send($message, $discord);

                // Ping::send($message, $discord);
            }
        }
    }
}
