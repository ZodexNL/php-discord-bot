<?php

namespace src\Commands\Initialize;

use Discord\Builders\CommandBuilder;
use Discord\Discord;
use LengthException;
use DomainException;
use InvalidArgumentException;
use OverflowException;
use Exception;

class CreateAllCommands
{
    private $cmdArr = [];

    public function __construct(Discord $discord)
    {
        $directory = 'src/Commands/Commands/';
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));

        foreach ($scanned_directory as &$command) {
            $command = "src\Commands\Commands\\" . str_replace('.php', '', $command);
        }

        $this->cmdArr = $scanned_directory;

        $this->create($discord);
    }

    /**
     * 
     * Create all commands from the commands dir
     * 
     * @param Discord $discord 
     * @return void 
     * @throws LengthException 
     * @throws DomainException 
     * @throws InvalidArgumentException 
     * @throws OverflowException 
     * @throws Exception 
     */
    private function create(Discord $discord): void
    {
        foreach ($this->cmdArr as $file) {
            $op = $file::getOptions($discord);

            if (!$op === null) {
                $discord->application->commands->save(
                    $discord->application->commands->create(
                        CommandBuilder::new()
                            ->setName($file::getName())
                            ->setDescription($file::getDescription())
                            ->setType($file::getType())
                            ->addOption($op)
                            ->toArray()
                    )
                );

                continue;
            }

            $discord->application->commands->save(
                $discord->application->commands->create(
                    CommandBuilder::new()
                        ->setName($file::getName())
                        ->setDescription($file::getDescription())
                        ->setType($file::getType())
                        ->toArray()
                )
            );
        }
    }
}
