<?php

declare(strict_types=1);

namespace Ghjayce\DrawRandom\Processor;

use Ghjayce\DrawRandom\Formatter\ArrayEncoder;
use Ghjayce\DrawRandom\Interface\EncoderInterface;

class ArrayProcessor implements EncoderInterface
{
    use ArrayEncoder;
}
