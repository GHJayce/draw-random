<?php

declare(strict_types=1);

namespace GhjayceTest\DrawRandom\DrawRandom;

use Ghjayce\DrawRandom\DrawRandom;
use Ghjayce\DrawRandom\Exception\DrawRandomException;
use Ghjayce\DrawRandom\Processor\StringProcessor;
use GhjayceTest\DrawRandom\TestCaseBase;

class TakeOneTest extends TestCaseBase
{
    public function testCaseA(): void
    {
        $prizes = [[1, 5]];
        $result = $this->arrayDrawRandom->takeOne($prizes);
        $expect = [
            'number' => $result['number'],
            'range' => [1, 5],
            'prizes' => $this->arrayDrawRandom->slicing(1, 5, $result['number']),
        ];
        $this->assertEquals($expect, $result);
    }
}
