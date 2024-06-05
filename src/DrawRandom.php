<?php

declare(strict_types=1);

namespace Ghjayce\DrawRandom;

use Ghjayce\DrawRandom\Interface\EncoderInterface;
use Ghjayce\DrawRandom\Processor\ArrayProcessor;

class DrawRandom
{
    public function __construct(protected ?EncoderInterface $processor = null)
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

    public function takeOne(array &$prizes):? array
    {
        if (!$prizes) {
            return null;
        }
        $prize = $this->pop($prizes);
        $prize = $this->unpack($prize);
        $range = [];
        if (!isset($prize[1])) {
            $number = (int) $prize[0];
        } else {
            $min = (int) $prize[0];
            $max = (int) $prize[1];
            $number = $this->pick($min, $max);
            $range = [$min, $max];
        }
        return compact('number', 'range');
    }

    public function take(int $count, array $prizes): array
    {
        $numbers = [];
        $prizes = $this->shuffle($prizes);
        for ($i = $count; $i > 0; $i--) {
            if (!$prizes) {
                break;
            }
            $result = $this->takeOne($prizes);
            ['number' => $number, 'range' => $range] = $result;
            $numbers[] = $number;
            if ($range) {
                [$min, $max] = $range;
                $slices = $this->slicing($min, $max, $number);
                if ($slices) {
                    array_push($prizes, ...$slices);
                }
            }
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

    protected function pop(array &$prizes): mixed
    {
        return array_shift($prizes);
    }

    protected function pick(int $min, int $max): int
    {
        return mt_rand($min, $max);
    }
}
