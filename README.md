# Advent of Code 2021 solutions

This repository contains my solutions for the [Advent of Code 2021](https://adventofcode.com/2021/).
The solutions have been written with using the PHP programming language. I 
generally try to avoid uploading solutions to the puzzles until the next one has
been released in order encourage people to come up with their own solutions
first.

Overall, my intention in Advent of Code 2021 has been to explore strict statically
typed PHP. The idea is to provide solution for each puzzle and conform to the
strictest static analysis levels of both Psalm and PHPStan.

## Usage

To list all the implemented tasks (i.e. solutions) run

```shell
./bin/console task:list
```

To run a specific task, use the following command

```shell
./bin/console task:run <taskname> [<input_file>]
```

Where `<taskname>` is one of the codes provided by the aforementioned task list,
e.g "1-1", and the `<input_file>` option is the file to use for input
(otherwise, the default provided in the repository is used).

## Copyright

Copyright (c) 2021 Riikka Kalliomäki
