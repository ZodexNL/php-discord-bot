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
    public $cmdArr = [];
    public $cmdNameArr = [];

    public function __construct(Discord $discord, bool $run)
    {
        $directory = 'src/Commands/Commands/';
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));

        foreach ($scanned_directory as &$command) {
            $name = strtolower(str_replace('.php', '', $command));
            $command = "src\Commands\Commands\\" . str_replace('.php', '', $command);
            $this->cmdNameArr[$name] = $command;
        }

        $this->cmdArr = $scanned_directory;

        if ($run) {
            $this->create($discord);
        }
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

            if ($op === null) {
                $discord->application->commands->save(
                    $discord->application->commands->create(
                        CommandBuilder::new()
                            ->setName($file::getName())
                            ->setDescription($file::getDescription())
                            ->setType($file::getType())
                            ->toArray()
                    )
                );
            } else {
                // Support multiple options
                $commandBuilder = CommandBuilder::new()
                    ->setName($file::getName())
                    ->setDescription($file::getDescription())
                    ->setType($file::getType());

                foreach ($op as $option) {
                    $commandBuilder->addOption($option);
                }

                $command = $commandBuilder->toArray();
                $discord->application->commands->save($discord->application->commands->create($command));
            }
        }
    }
}
