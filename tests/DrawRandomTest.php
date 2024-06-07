<?php

declare(strict_types=1);

namespace GhjayceTest\DrawRandom;

use Ghjayce\DrawRandom\Processor\ArrayProcessor;
use Ghjayce\DrawRandom\Processor\StringProcessor;
use GhjayceExample\DrawRandom\Mock\DrawRandomMock;

class DrawRandomTest extends TestCaseBase
{
    public function testUnique(): void
    {
        $min = 1;
        $max = 1000;
        $repeats = [];
        $numbers = $prizes = [];
        $prizes[] = $this->arrayDrawRandom->pack($min, $max);
        while ($prizes) {
            $result = $this->arrayDrawRandom->take(20, $prizes);

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

    public function testDefaultProcessor(): void
    {
        $processor = new StringProcessor();
        $drawRandom = new DrawRandomMock($processor);
        $property = 'processor';
        $this->assertEquals($drawRandom->$property, $processor);

        $processor = new ArrayProcessor();
        $drawRandom = new DrawRandomMock();
        $this->assertEquals($drawRandom->$property, $processor);
    }
}
