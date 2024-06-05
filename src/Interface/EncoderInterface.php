<?php

namespace Ghjayce\DrawRandom\Interface;

interface EncoderInterface
{
    public function decode(mixed $data): mixed;
    public function encode(mixed $data): mixed;
}