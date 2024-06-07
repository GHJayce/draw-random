<?php

declare(strict_types=1);

namespace GhjayceTest\DrawRandom\DrawRandom;

use Ghjayce\DrawRandom\DrawRandom;
use Ghjayce\DrawRandom\Exception\DrawRandomException;
use Ghjayce\DrawRandom\Processor\StringProcessor;
use GhjayceTest\DrawRandom\TestCaseBase;

class TakeTest extends TestCaseBase
{
    public function testCaseA(): void
    {
        $prizes = [[1, 2]];
        $result = $this->arrayDrawRandom->take(2, $prizes);
        sort($result['numbers']);
        $expect = [
            'numbers' => [1, 2],
            'prizes' => [],
        ];
        $this->assertEquals($expect, $result);
    }

    public function testCaseB(): void
    {
        $prizes = [[1, 2]];
        $result = $this->arrayDrawRandom->take(1, $prizes);
        $prizes = $result['numbers'][0] === 1 ? [[2]] : [[1]];
        $expect = [
            'numbers' => $result['numbers'],
            'prizes' => $prizes,
        ];
        $this->assertEquals($expect, $result);
    }
}
