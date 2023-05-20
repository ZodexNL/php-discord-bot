<?php

namespace src\Commands\Initialize;

use Discord\Discord;
use Exception;

class DeleteAllCommands
{
    /**
     * Delete all application commands on client start
     * @param Discord $discord 
     * @return void 
     * @throws Exception 
     */
    public static function delete(Discord $discord): void
    {
        $discord->application->commands->freshen()->done(function ($commands) {
            foreach ($commands as $command) {
                $commands->delete($command);
            }
        });
    }
}
