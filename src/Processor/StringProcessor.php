<?php

declare(strict_types=1);

namespace Ghjayce\DrawRandom\Processor;

use Ghjayce\DrawRandom\Formatter\StringEncoder;
use Ghjayce\DrawRandom\Interface\EncoderInterface;

class StringProcessor implements EncoderInterface
{
    use StringEncoder;
}
