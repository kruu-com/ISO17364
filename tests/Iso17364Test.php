<?php declare(strict_types=1);

use Iso17364\Afi;
use Iso17364\Iso17364;
use PHPUnit\Framework\TestCase;

final class Iso17364Test extends TestCase
{

    private $testData = [
        "SKRUUFB 2000" => '29A14CB4955460A0CB0C3086',
        "SPRC 4490" => "21A14D0483834D39C218",
        "SCBX 2735" => "21A14C3098832DF3D618",
        "SCBX 2736" => "21A14C3098832DF3DA18",
        "SPR 880" => "19A14D04A0E38C21",
        "SPR 879" => "19A14D04A0E37E61",
        "SPR 876" => "19A14D04A0E37DA1",
        "37SUN12345678999755512300FFFAS+123456" => "79A1CF74D53B1CB3D35DB7E39E79DF5D75C72CF0C06186053AF1CB3D35DA1820",
    ];

    public function testCorrectEncoding(): void
    {
        $iso = new Iso17364();

        var_dump(phpversion());

        foreach ($this->testData as $in => $out) {
            $this->assertEquals($out, $iso->encode($in, false, false, Afi::of(Afi::PRODUCT_TAGGING)));
        }
    }

    public function testCorrectDecoding(): void
    {
        $testData = array_flip($this->testData);

        $iso = new ISO17364();

        foreach ($testData as $in => $out) {

            $str = substr($in, 4);

            $this->assertEquals($out, $iso->decode($str));
        }
    }

}

