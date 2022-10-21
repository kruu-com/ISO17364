<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use ISO17364\ISO17364;

final class ISO17364Test extends TestCase
{
    public function testCorrectEncoding(): void
    {
        $input = "SPRC 4490";
        $output = "4d0483834d39c218";

        //$input = "S";
        //$output = "4E18";


        $iso = new ISO17364();

        $this->assertEquals($output, $iso->encode($input));
    }

}

