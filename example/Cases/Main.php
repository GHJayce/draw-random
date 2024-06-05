<?php

declare(strict_types=1);

namespace GhjayceExample\DrawRandom;

use Ghjayce\DrawRandom\DrawRandom;
use Ghjayce\DrawRandom\Processor\ArrayProcessor;
use Ghjayce\DrawRandom\Processor\StringProcessor;

class Main
{
    public function caseA(): void
    {
        $drawRandom = new DrawRandom();
        //$processor = new StringProcessor();
        $processor = new ArrayProcessor();
        $drawRandom->setProcessor($processor);
        $min = 1;
        $max = 1000;
        $prizes = [];
        $prizes[] = $drawRandom->pack($min, $max);
        $index = 1;
        while ($prizes) {
            $result = $drawRandom->take(20, $prizes);
            $prizes = $result['prizes'];
            echo $index++, "\n";
            echo json_encode($result), "\n\n";
        }
    }
}

require './vendor/autoload.php';

$instance = new Main();
$instance->caseA();