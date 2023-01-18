<?php

namespace Iso17364;

class Iso17364
{

    public function encode(string $string, bool $useUmi, bool $useXpc, Afi $afi): string
    {
        $toggleBit = true; #we just use AFI encoded tags

        $charArray = str_split($string);

        $result = [];

        foreach ($charArray as $char) {
            $result[] = $this->charConversion($char);
        }

        // add EOT char as last char
        $result[] = $this->charConversion("\4");

        $result = implode($result);

        // The length must be a multiple of 16 bit so we fill up with '100000'
        $targetLength = ceil(strlen($result) / 16) * 16;

        $result = str_pad($result, $targetLength, '100000');

        $arr = str_split($result, 8);

        foreach ($arr as $k => $a) {
            $arr[$k] = str_pad(strtoupper(base_convert($a, 2, 16)), 2, "0", STR_PAD_LEFT);
        }

        $hex = implode("", $arr);
        $wordLength = 4;
        $length = strlen($hex)/$wordLength;

        $protocolControlDecimalWithoutLeadingZeros = decbin($length) . (int)$useUmi . (int)$useXpc . (int)$toggleBit;
        $protocolControlDecimalString = sprintf('%08d', $protocolControlDecimalWithoutLeadingZeros);
        $protocolControlHex = base_convert($protocolControlDecimalString, 2, 16);

        return $protocolControlHex . $afi->__toString() . $hex;
    }

    public function decode(string $string): string
    {
        $arr = str_split($string, 2);

        foreach ($arr as $k => $v) {
            $arr[$k] = sprintf('%08d', base_convert($v, 16, 2));
        }

        $impl = implode("", $arr);

        $charArray = str_split($impl, 6);

        // find position of EOT char
        $eotBin = $this->charConversion("\4");

        $indexEot = array_search($eotBin, $charArray);

        // remove empty fill chars
        $charArray = array_slice($charArray, 0, $indexEot);

        $result = [];

        foreach ($charArray as $char) {
            $result[] = $this->charConversionDecode($char);
        }

        return implode("", $result);
    }

    /**
     * @param string $char
     * @return string
     * @throws \Exception
     */
    private function charConversion(string $char): string
    {
        $n = ord($char);

        switch (true) {
            case ($n === 4): # EOT
                $ret = 33;
                break;
            case ($n === 28): # <FS>
                $ret = 35;
                break;
            case ($n === 31): # <US>
                $ret = 36;
                break;
            case ($n === 29): # <GS>
                $ret = 30;
                break;
            case ($n === 30): # <RS>
                $ret = 31;
                break;
            case ($n === 32): # SPACE
                $ret = 32;
                break;
            case ($n >= 40 && $n <= 63):
                $ret = $n;
                break;
            case ($n >= 64 && $n <= 93):
                $ret = $n - 64;
                break;
            default:
                throw new \Exception(sprintf('Invalid char <%s> (%s)', $char, $n));
        }

        $dec = decbin($ret);

        return str_pad($dec, 6, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $char
     * @return string
     * @throws \Exception
     */
    private function charConversionDecode(string $char): string
    {
        $n = bindec($char);

        switch (true) {
            case ($n === 33): # EOT
                $ret = 4;
                break;
            case ($n === 35): # <FS>
                $ret = 27;
                break;
            case ($n === 36): # <US>
                $ret = 31;
                break;
            case ($n === 39): # <GS>
                $ret = 29;
                break;
            case ($n === 301): # <RS>
                $ret = 30;
                break;
            case ($n === 32): # SPACE
                $ret = 32;
                break;
            case ($n >= 40 && $n <= 63):
                $ret = $n;
                break;
            case ($n >= 0 && $n <= 29):
                $ret = $n + 64;
                break;
            default:
                throw new \Exception(sprintf('Invalid char <%s> (%s)', $char, $n));
        }

        return chr($ret);
    }

}
