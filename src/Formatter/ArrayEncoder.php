<?php

declare(strict_types=1);

namespace Ghjayce\DrawRandom\Formatter;

trait ArrayEncoder
{
    /**
     * @param array $item
     * @return array
     */
    public function decode(mixed $item): array
    {
        return $item;
    }

    /**
     * @param array $item
     * @return array
     */
    public function encode(mixed $item): array
    {
        return $item;
    }
}
