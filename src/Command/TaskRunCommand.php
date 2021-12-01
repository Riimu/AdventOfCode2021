<?php

namespace Riimu\AdventOfCode2021\Command;

use Riimu\AdventOfCode2021\TaskInterface;
use Riimu\AdventOfCode2021\TaskList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaskRunCommand extends Command
{
    protected static $defaultName = 'task:run';
    protected static $defaultDescription = 'Runs the provided task';

    protected function configure(): void
    {
        $this->addArgument('task', InputArgument::REQUIRED, 'The task to run');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $taskName = $this->getTaskName($input);

        if (!isset(TaskList::TASK_LIST[$taskName])) {
            $this->error($output, "No task named '$taskName'");
            return Command::FAILURE;
        }

        $task = $this->instantiate($taskName);
        $result = $task->run();

        $output->writeln($result);

        return Command::SUCCESS;
    }

    private function error(OutputInterface $output, string $text): void
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output->getErrorOutput()->writeln($text);
            return;
        }

        $output->writeln($text);
    }

    private function getTaskName(InputInterface $input): string
    {
        $name = $input->getArgument('task');

        if (!\is_string($name)) {
            throw new \UnexpectedValueException('Unexpected value for task name: ' . get_debug_type($name));
        }

        return $name;
    }

    private function instantiate(string $name): TaskInterface
    {
        $class = TaskList::TASK_LIST[$name];

        if (!class_exists($class) || !is_a($class, TaskInterface::class, true)) {
            throw new \RuntimeException("Invalid task class: $class");
        }

        return new $class();
    }
}
