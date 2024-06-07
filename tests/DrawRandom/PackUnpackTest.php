<?php

declare(strict_types=1);

namespace GhjayceTest\DrawRandom\DrawRandom;

use Ghjayce\DrawRandom\DrawRandom;
use Ghjayce\DrawRandom\Exception\DrawRandomException;
use Ghjayce\DrawRandom\Processor\StringProcessor;
use GhjayceTest\DrawRandom\TestCaseBase;

class PackUnpackTest extends TestCaseBase
{
    public function testCaseA(): void
    {
        $result = $this->arrayDrawRandom->pack(1, 2);
        $expect = [1, 2];
        $this->assertEquals($expect, $result);
    }

    public function testCaseB(): void
    {
        $result = $this->arrayDrawRandom->pack(1);
        $expect = [1];
        $this->assertEquals($expect, $result);
    }

    public function testCaseC(): void
    {
        $result = $this->stringDrawRandom->pack(1, 2);
        $expect = '1,2';
        $this->assertEquals($expect, $result);
    }

    public function testCaseD(): void
    {
        $result = $this->stringDrawRandom->pack(1);
        $expect = '1';
        $this->assertEquals($expect, $result);
    }
}
