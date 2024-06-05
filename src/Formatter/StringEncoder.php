<?php

declare(strict_types=1);

namespace Ghjayce\DrawRandom\Formatter;

trait StringEncoder
{
    /**
     * @param string $item
     * @return array
     */
    public function decode(mixed $item): array
    {
        return explode(',', $item);
    }

    /**
     * @param array $item
     * @return string
     */
    public function encode(mixed $item): string
    {
        return implode(',', $item);
    }
}
