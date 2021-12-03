<?php

namespace Riimu\AdventOfCode2021\Command;

use Riimu\AdventOfCode2021\TaskList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaskListCommand extends Command
{
    protected static $defaultName = 'task:list';
    protected static $defaultDescription = 'Lists all available tasks to run';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $taskList = new TaskList();
        $tasks = $taskList->getTasks();

        uksort($tasks, fn (string $a, string $b): int => strnatcasecmp($a, $b));

        $output->writeln('List of implemented tasks:');
        $output->writeln('');

        foreach ($tasks as $code => $class) {
            $output->writeln(sprintf(' %5s - %s', $code, $class::getName()));
        }

        return Command::SUCCESS;
    }
}
