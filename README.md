This library encodes and decodes the content of an RFID defined in the ISO 17364.

# Testing

## Install vendors

`docker run --rm --interactive --tty --volume $PWD:/app composer install --dev`

## Run tests

`docker compose run php vendor/bin/phpunit .`

# 6-Bit ASCII table

| ASCII        | Binary | ASCII | Binary | ASCII | Binary | ASCII  | Binary |
|--------------|--------|-------|--------|-------|--------|--------|--------|
| Space        | 100000 | 0     | 110000 | @     | 000000 | P      | 010000 |
| \<EOT\>      | 100001 | 1     | 110001 | A     | 000001 | Q      | 010001 |
| \<Reserved\> | 100010 | 2     | 110010 | B     | 000010 | R      | 010010 |
| \<FS\>       | 100011 | 3     | 110011 | C     | 000011 | S      | 010011 |
| \<US\>       | 100100 | 4     | 110100 | D     | 000100 | T      | 010100 |
| \<Reserved\> | 100101 | 5     | 110101 | E     | 000101 | U      | 010101 |
| \<Reserved\> | 100110 | 6     | 110110 | F     | 000110 | V      | 010110 |
| \<Reserved\> | 100111 | 7     | 110111 | G     | 000111 | W      | 010111 |
| (            | 101000 | 8     | 111000 | H     | 001000 | X      | 011000 |
| )            | 101001 | 9     | 111001 | I     | 001001 | Y      | 011001 |
| *            | 101010 | :     | 111010 | J     | 001010 | Z      | 011010 |
| +            | 101011 | ;     | 111011 | K     | 001011 | [      | 011011 |
| ,            | 101100 | <     | 111100 | L     | 001100 | \      | 011100 |
| -            | 101101 | =     | 111101 | M     | 001101 | ]      | 011101 |
| .            | 101110 | >     | 111110 | N     | 001110 | \<GS\> | 011110 |
| /            | 101111 | ?     | 111111 | O     | 001111 | \<RS\> | 011111 |

# Documentation

## Structure

An encoded string consists out of

- Protocol Control (PC)
  - Length (always 5 decimals - leading zeros if required!)
  - Use Memory Indicator (0|1)
  - XPC Indicator (0|1)
  - Numbering System Identifier Toggle (0|1)
  - Application Family Identifier (AFI)
- Electronic Product Code (EPC)

The length is the decimal representation of the word count of the EPC. A word has a length of 4 Hex chars.

## Example

String: `SPRC 4490`  
Encoded: `21A14D0483834D39C218`

The actual data in the EPC is `4D0483834D39C218` (16 chars) which results in 4 words since one word as a length of 4 Hex chars. The decimal 
representation is `00100` since we need a length of 5 decimals with leading zeros.

The Use Memory Indicator and XPC Indicator are 0 and the Numbering System Identifier Toggle is 1.

The first part of the decimal representation of the PC is `00100001` which results in `21` hex.

The Application Family Identifier for product tagging is `A1` as Hex. So the PC is `21A1`




