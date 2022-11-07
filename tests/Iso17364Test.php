<?php declare(strict_types=1);

use KruuCom\Iso17364;
use PHPUnit\Framework\TestCase;

final class Iso17364Test extends TestCase
{

    private $testData = [
        "SPRC 4490" => "4D0483834D39C218",
        "SCBX 2735" => "4C3098832DF3D618",
        "SCBX 2736" => "4C3098832DF3DA18",
        "SPR 880" => "4D04A0E38C21",
        "SPR 879" => "4D04A0E37E61",
    ];

    public function testCorrectEncoding(): void
    {
        $iso = new Iso17364();

        foreach ($this->testData as $in => $out) {
            $this->assertEquals($out, $iso->encode($in));
        }
    }

    public function testCorrectDecoding(): void
    {
        $testData = array_flip($this->testData);

        $testData["4D04A0E37E610000"] = "SPR 879";
        $testData["4D04A0E37E61"] = "SPR 879";

        $iso = new ISO17364();

        foreach ($testData as $in => $out) {
            $this->assertEquals($out, $iso->decode($in));
        }
    }
}

