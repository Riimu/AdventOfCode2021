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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tasks = array_keys(TaskList::TASK_LIST);

        natcasesort($tasks);

        foreach ($tasks as $name) {
            $output->writeln($name);
        }

        return Command::SUCCESS;
    }
}
