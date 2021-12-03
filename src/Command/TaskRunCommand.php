<?php

namespace Riimu\AdventOfCode2021\Command;

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
        $this->addArgument('input', InputArgument::OPTIONAL, 'Input file to use');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $taskList = new TaskList();
        $taskName = $this->getTaskName($input);

        if (!$taskList->hasTask($taskName)) {
            $this->error($output, "No task named '$taskName'");
            return Command::FAILURE;
        }

        $task = $taskList->getTask($taskName);

        $output->writeln('Running task: ' . $task::getName());
        $inputFile = $input->getArgument('input');

        if ($inputFile) {
            $task->setInput($inputFile);
        }

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
}
