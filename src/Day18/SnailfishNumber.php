<?php

namespace Riimu\AdventOfCode2021\Day18;

class SnailfishNumber implements SnailfishInterface
{
    private SnailfishNumber $parent;

    public function __construct(
        private SnailfishInterface $left,
        private SnailfishInterface $right,
    ) {
        $this->left->setParent($this);
        $this->right->setParent($this);
    }

    public function setParent(SnailfishNumber $number): void
    {
        $this->parent = $number;
    }

    public function add(SnailfishNumber $number): void
    {
        $this->left = new SnailfishNumber($this->left, $this->right);
        $this->right = $number;

        $this->left->setParent($this);
        $this->right->setParent($this);
        $this->reduce();
    }

    public function reduce(): void
    {
        while (true) {
            if ($this->explode()) {
                continue;
            }

            if ($this->split()) {
                continue;
            }

            break;
        }
    }

    public function explode(int $depth = 1): bool
    {
        if ($this->left instanceof SnailfishValue && $this->right instanceof SnailfishValue) {
            if ($depth < 5) {
                return false;
            }

            $this->parent->passLeft($this, $this->left);
            $this->parent->passRight($this, $this->right);
            $this->parent->replace($this, new SnailfishValue(0));

            return true;
        }

        foreach ([$this->left, $this->right] as $number) {
            if ($number instanceof self && $number->explode($depth + 1)) {
                return true;
            }
        }

        return false;
    }

    public function split(): bool
    {
        return $this->left->split() || $this->right->split();
    }

    public function replace(SnailfishInterface $number, SnailfishInterface $new): void
    {
        if ($this->left === $number) {
            $this->left = $new;
            $this->left->setParent($this);
            return;
        }

        if ($this->right !== $number) {
            throw new \RuntimeException('Trying to detach a number that is not a sub node');
        }

        $this->right = $new;
        $this->right->setParent($this);
    }

    private function passLeft(SnailfishNumber $from, SnailfishValue $number): void
    {
        if ($from === $this->right) {
            $this->left->addRight($number);
        } elseif ($from !== $this->left) {
            throw new \RuntimeException('Unexpected source of number');
        } elseif (isset($this->parent)) {
            $this->parent->passLeft($this, $number);
        }
    }

    public function addLeft(SnailfishValue $number): void
    {
        $this->left->addLeft($number);
    }

    private function passRight(SnailfishNumber $from, SnailfishValue $number): void
    {
        if ($from === $this->left) {
            $this->right->addLeft($number);
        } elseif ($from !== $this->right) {
            throw new \RuntimeException('Unexpected source of number');
        } elseif (isset($this->parent)) {
            $this->parent->passRight($this, $number);
        }
    }

    public function addRight(SnailfishValue $number): void
    {
        $this->right->addRight($number);
    }

    public function getMagnitude(): int
    {
        return 3 * $this->left->getMagnitude() + 2 * $this->right->getMagnitude();
    }

    public function toString(): string
    {
        return sprintf('[%s,%s]', $this->left->toString(), $this->right->toString());
    }
}
