<?php

declare(strict_types=1);

namespace GhjayceTest\DrawRandom\DrawRandom;

use Ghjayce\DrawRandom\DrawRandom;
use Ghjayce\DrawRandom\Exception\DrawRandomException;
use Ghjayce\DrawRandom\Processor\StringProcessor;
use GhjayceTest\DrawRandom\TestCaseBase;

class SlicingTest extends TestCaseBase
{
    public function testCaseA(): void
    {
        $min = 1;
        $max = 100;
        $number = 88;
        $result = $this->arrayDrawRandom->slicing($min, $max, $number);
        $expect = [
            [1, 87],
            [89, 100],
        ];
        $this->assertEquals($expect, $result);
    }

    public function testCaseB(): void
    {
        $result = $this->arrayDrawRandom->slicing(1, 1, 1);
        $expect = [];
        $this->assertEquals($expect, $result);
    }

    public function testCaseC(): void
    {
        $min = 1;
        $max = 100;
        $number = 88;
        $result = $this->stringDrawRandom->slicing($min, $max, $number);
        $expect = [
            '1,87',
            '89,100',
        ];
        $this->assertEquals($expect, $result);
    }
}
