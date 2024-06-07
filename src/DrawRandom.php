<?php

declare(strict_types=1);

namespace Ghjayce\DrawRandom;

use Ghjayce\DrawRandom\Exception\DrawRandomException;
use Ghjayce\DrawRandom\Interface\EncoderInterface;
use Ghjayce\DrawRandom\Processor\ArrayProcessor;

class DrawRandom
{
    public function __construct(protected ?EncoderInterface $processor = null)
    {
        $this->setDefaultProcessor();
    }

    protected function setDefaultProcessor(): void
    {
        if (!$this->processor) {
            $this->setProcessor(new ArrayProcessor());
        }
    }

    public function setProcessor(EncoderInterface $processor): self
    {
        $this->processor = $processor;
        return $this;
    }

    public function slicing(int $min, int $max, int $number): array
    {
        $result = [];
        if ($number > $min) {
            $beforeMax = $number - 1;
            $range = $beforeMax === $min ? [$min] : [$min, $beforeMax];
            $result[] = $this->pack(...$range);
        }
        if ($number < $max) {
            $afterMin = $number + 1;
            $range = $afterMin === $max ? [$max] : [$afterMin, $max];
            $result[] = $this->pack(...$range);
        }
        return $result;
    }

    public function takeOne(array $prizes, bool $isRandom = true):? array
    {
        if (!$prizes) {
            return null;
        }
        if ($isRandom && !isset($prizes[1])) {
            $index = array_rand($prizes, 1);
            if ($index !== 0) {
                $prizes = $this->swap($prizes, $index, 0);
            }
        }
        $prize = array_shift($prizes);
        $prize = $this->unpack($prize);
        $range = [];
        if (!isset($prize[1])) {
            $number = (int) $prize[0];
        } else {
            $min = (int) $prize[0];
            $max = (int) $prize[1];
            $number = $this->random($min, $max);
            $range = [$min, $max];
            $slices = $this->slicing($min, $max, $number);
            if ($slices) {
                array_push($prizes, ...$slices);
            }
        }
        return compact('number', 'range', 'prizes');
    }

    public function take(int $count, array $prizes): array
    {
        $numbers = [];
        $prizes = $this->shuffle($prizes);
        for ($i = $count; $i > 0; $i--) {
            if (!$prizes) {
                break;
            }
            ['number' => $number, 'prizes' => $prizes] = $this->takeOne($prizes, false);
            $numbers[] = $number;
        }
        return compact('prizes', 'numbers');
    }

    public function pack(int $min, int $max = null): mixed
    {
        $range = [$min];
        if ($max !== null) {
            $range[] = $max;
        }
        return $this->encode($range);
    }

    public function unpack(mixed $prize): array
    {
        return $this->decode($prize);
    }

    private function decode(mixed $prize): array
    {
        return $this->processor->decode($prize);
    }

    private function encode(array $prize): mixed
    {
        return $this->processor->encode($prize);
    }

    protected function shuffle(array $prizes = []): array
    {
        if (!$prizes) {
            return $prizes;
        }
        shuffle($prizes);
        return $prizes;
    }

    public function random(int $min, int $max): int
    {
        return mt_rand($min, $max);
    }

    public function swap(array $prizes, int $originPosition, int $targetPosition): array
    {
        if (!isset($prizes[$originPosition], $prizes[$targetPosition])) {
            throw new DrawRandomException('Position does not exists.');
        }
        $temp = $prizes[$originPosition];
        $prizes[$originPosition] = $prizes[$targetPosition];
        $prizes[$targetPosition] = $temp;
        return $prizes;
    }
}
