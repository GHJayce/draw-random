<?php

declare(strict_types=1);

namespace GhjayceTest\DrawRandom\DrawRandom;

use Ghjayce\DrawRandom\Exception\DrawRandomException;
use GhjayceTest\DrawRandom\TestCaseBase;

class SwapTest extends TestCaseBase
{
    public function testCaseA(): void
    {
        $prizes = [[1, 5], [6, 8], [90, 100], [12, 18]];
        $result = $this->arrayDrawRandom->swap($prizes, 0, 2);
        $expect = [[90, 100], [6, 8], [1, 5], [12, 18]];
        $this->assertEquals($expect, $result);
    }

    public function testCaseB(): void
    {
        $prizes = [[1, 5], [6, 8], [90, 100], [12, 18]];
        $this->expectException(DrawRandomException::class);
        $this->arrayDrawRandom->swap($prizes, 0, 4);
    }

    public function testCaseC(): void
    {
        $prizes = [[1, 5], [6, 8], [90, 100], [12, 18]];
        $this->expectException(DrawRandomException::class);
        $this->arrayDrawRandom->swap($prizes, 5, 6);
    }

    public function testCaseD(): void
    {
        $prizes = [[1, 5], [6, 8], [90, 100], [12, 18]];
        $this->expectException(DrawRandomException::class);
        $this->arrayDrawRandom->swap($prizes, 7, 3);
    }
}
