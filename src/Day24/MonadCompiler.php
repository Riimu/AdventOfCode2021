<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2021\Day24;

use Riimu\AdventOfCode2021\AbstractTask;
use Riimu\AdventOfCode2021\Typed\Integers;

class MonadCompiler
{
    public function compile(array $input): AluRunner
    {
        $format = '$%s = %s;';
        $expressions = [];

        /** @var array<int, ValueInterface> $variables */
        $variables = [];
        $inputNumber = 0;
        $previous = '';

        foreach (['x', 'y', 'z', 'w'] as $name) {
            $variables[$name] = new ConstantValue(0);
        }

        foreach ($input as $line) {
            if (str_starts_with($line, 'inp')) {
                $name = explode(' ', $line)[1];

                if ($previous !== $name && $previous !== '') {
                    $expressions[] = sprintf($format, $previous, $variables[$previous]->getExpression());
                    $variables[$previous] = new VariableValue($previous);
                }

                $variables[$name] = new InputValue($inputNumber++);
                $previous = $name;
                continue;
            }

            [$command, $variableInput, $valueInput] = explode(' ', $line);

            $variable = $variables[$variableInput];
            $value = $variables[$valueInput] ?? new ConstantValue(Integers::parse($valueInput));

            if ($value instanceof ConstantValue) {
                if ($command === 'add' && $value->value === 0) {
                    continue;
                }
                if ($command === 'mul' && $value->value === 0) {
                    $variables[$variableInput] = new ConstantValue(0);
                    continue;
                }
                if ($command === 'div' && $value->value === 1) {
                    continue;
                }

                if ($variable instanceof ConstantValue) {
                    $result = match ($command) {
                        'add' => $variable->value + $value->value,
                        'mul' => $variable->value * $value->value,
                        'div' => intdiv($variable->value, $value->value),
                        'mod' => $variable->value % $value->value,
                        'eql' => $variable->value === $value->value ? 1 : 0,
                        default => throw new \RuntimeException("Unexpected command '$command'"),
                    };

                    $variables[$variableInput] = new ConstantValue($result);
                    continue;
                }
            }

            if (\in_array($command, ['mul', 'div', 'mod'], true) &&
                $variable instanceof ConstantValue &&
                $variable->value === 0
            ) {
                $variables[$variableInput] = new ConstantValue(0);
                continue;
            }

            if ($variableInput !== $previous) {
                $expressions[] = sprintf($format, $previous, $variables[$previous]->getExpression());
                $variables[$previous] = new VariableValue($previous);

                if ($valueInput === $previous) {
                    $value = $variables[$valueInput];
                }

                $previous = $variableInput;
            }

            if ($command === 'add' && $variable instanceof ConstantValue) {
                $variables[$variableInput] = $value;
                continue;
            }

            $expression = match ($command) {
                'add' => sprintf('%s + %s', $variable->getExpression(), $value->getExpression()),
                'mul' => sprintf('%s * %s', $variable->getExpression(), $value->getExpression()),
                'div' => sprintf('intdiv(%s, %s)', $variable->getExpression(), $value->getExpression()),
                'mod' => sprintf('%s %% %s', $variable->getExpression(), $value->getExpression()),
                'eql' => sprintf('%s === %s ? 1 : 0', $variable->getExpression(), $value->getExpression()),
                default => throw new \RuntimeException("Unexpected command '$command'"),
            };

            $variables[$variableInput] = new ExpressionValue($expression);
        }

        $expressions[] = sprintf($format, 'z', $variables['z']->getExpression());

        $temp = tempnam(sys_get_temp_dir(), 'php');
        $name = sprintf('AluRunner%s', md5($temp));
        $code = sprintf('        %s', implode("\n        ", $expressions));

        $contents = <<<PHPCODE
            <?php
            
            class $name implements \Riimu\AdventOfCode2021\Day24\AluRunner
            {
                public function calculate(array \$input): int {
                    $code
                    
                    return \$z;
                }
            }\n
            PHPCODE;

        file_put_contents($temp, $contents);

        require $temp;
        unlink($temp);

        return new $name();
    }
}
