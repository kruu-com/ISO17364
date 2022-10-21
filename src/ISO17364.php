<?php

namespace ISO17364;

class ISO17364 {

    public function encode(string $string): string
    {
        $charArray = str_split($string);

        $result = [];

        foreach ($charArray as $char) {
            $result[] = $this->charConversion($char);
        }

        // add EOT char as last char
        $result[] = $this->charConversion("\4");

        $result = implode($result);

        $targetLength = ceil(strlen($result) / 16) * 16;

        $result = str_pad($result, $targetLength, '100000');

        return base_convert($result, 2, 16);
    }

    /**
     * @param string $char
     * @return string
     * @throws \Exception
     */
    private function charConversion(string $char): string
    {
        $n = ord($char);

        switch(true) {
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
            case ($n >= 40 && $n <=63):
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

}
