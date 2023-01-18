<?php

namespace Iso17364;

use Iso17364\Afi\AfiException;

class Afi
{

    const PRODUCT_TAGGING = 'A1';

    protected string $afi;

    /**
     * @throws AfiException
     */
    public function __construct(string $afi)
    {
        $this->validate($afi);

        $this->afi = $afi;
    }

    public static function of(string $afi): self
    {
        return new self($afi);
    }

    public function __toString(): string
    {
        return $this->afi;
    }

    /**
     * @throws AfiException
     */
    protected function validate(string $afi)
    {
        if (!in_array($afi, [self::PRODUCT_TAGGING])) {
            throw new AfiException(sprintf('%s is not a valid AFI identifier.', $afi));
        }
    }
}
