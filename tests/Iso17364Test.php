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
        "SPR 876" => "4D04A0E37DA1",
        "37SUN12345678999755512300FFFAS+123456" => "CF74D53B1CB3D35DB7E39E79DF5D75C72CF0C06186053AF1CB3D35DA1820",
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

        $iso = new ISO17364();

        foreach ($testData as $in => $out) {
            $this->assertEquals($out, $iso->decode($in));
        }
    }
}

