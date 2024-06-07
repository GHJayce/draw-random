<?php

declare(strict_types=1);

namespace GhjayceTest\DrawRandom;

use Ghjayce\DrawRandom\DrawRandom;
use Ghjayce\DrawRandom\Processor\ArrayProcessor;
use Ghjayce\DrawRandom\Processor\StringProcessor;
use PHPUnit\Framework\TestCase;

class TestCaseBase extends TestCase
{
    protected DrawRandom $arrayDrawRandom;
    protected DrawRandom $stringDrawRandom;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->arrayDrawRandom = new DrawRandom(new ArrayProcessor());
        $this->stringDrawRandom = new DrawRandom(new StringProcessor());
    }

    public function test(): void
    {
        $this->assertEquals(1, 1);
    }
}
