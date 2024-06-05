<?php

declare(strict_types=1);

namespace GhjayceTest\DrawRandom;

use Ghjayce\DrawRandom\DrawRandom;
use Ghjayce\DrawRandom\Processor\StringProcessor;
use PHPUnit\Framework\TestCase;

class DrawRandomTest extends TestCase
{
    public function testSlicing(): void
    {
        $drawRandom = new DrawRandom();
        $min = 1;
        $max = 100;
        $number = 88;
        $result = $drawRandom->slicing($min, $max, $number);
        $expect = [
            [1, 87],
            [89, 100],
        ];
        $this->assertEquals($expect, $result);

        $result = $drawRandom->slicing(1, 1, 1);
        $expect = [];
        $this->assertEquals($expect, $result);

        $result = $drawRandom->setProcessor(new StringProcessor())->slicing($min, $max, $number);
        $expect = [
            '1,87',
            '89,100',
        ];
        $this->assertEquals($expect, $result);
    }

    public function testTakeOne(): void
    {
        $drawRandom = new DrawRandom();
        $prizes = [[1, 5]];
        $result = $drawRandom->takeOne($prizes);
        $expect = [
            'number' => $result['number'],
            'range' => [1, 5],
        ];
        $this->assertEquals($expect, $result);
    }

    public function testTake(): void
    {
        $drawRandom = new DrawRandom();
        $prizes = [[1, 2]];
        $result = $drawRandom->take(2, $prizes);
        sort($result['numbers']);
        $expect = [
            'numbers' => [1, 2],
            'prizes' => [],
        ];
        $this->assertEquals($expect, $result);


        $drawRandom = new DrawRandom();
        $prizes = [[1, 2]];
        $result = $drawRandom->take(1, $prizes);
        $prizes = $result['numbers'][0] === 1 ? [[2]] : [[1]];
        $expect = [
            'numbers' => $result['numbers'],
            'prizes' => $prizes,
        ];
        $this->assertEquals($expect, $result);
    }

    public function testPackUnPack(): void
    {
        $drawRandom = new DrawRandom();
        $result = $drawRandom->pack(1, 2);
        $expect = [1, 2];
        $this->assertEquals($expect, $result);

        $result = $drawRandom->pack(1);
        $expect = [1];
        $this->assertEquals($expect, $result);

        $drawRandom->setProcessor(new StringProcessor());
        $result = $drawRandom->pack(1, 2);
        $expect = '1,2';
        $this->assertEquals($expect, $result);

        $result = $drawRandom->pack(1);
        $expect = '1';
        $this->assertEquals($expect, $result);
    }

    public function testUnique(): void
    {
        $drawRandom = new DrawRandom();
        $min = 1;
        $max = 1000;
        $repeats = [];
        $numbers = $prizes = [];
        $prizes[] = $drawRandom->pack($min, $max);
        while ($prizes) {
            $result = $drawRandom->take(20, $prizes);

            $repeat = array_intersect($numbers, $result['numbers']);
            array_push($repeats, ...$repeat);

            array_push($numbers, ...$result['numbers']);
            $prizes = $result['prizes'];
        }

        $uniqueNumbers = array_unique($numbers);
        $this->assertEquals([], $repeats);
        $this->assertEquals(count($uniqueNumbers), $max);

        $mockRepeatNumbers = array_merge([1], $numbers);
        $countValues = array_count_values($mockRepeatNumbers);
        $this->assertEquals(2, $countValues[1]);
    }
}
