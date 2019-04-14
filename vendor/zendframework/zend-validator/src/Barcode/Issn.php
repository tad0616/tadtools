<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Validator\Barcode;

class Issn extends AbstractAdapter
{
    /**
     * Constructor for this barcode adapter
     */
    public function __construct()
    {
        $this->setLength([8, 13]);
        $this->setCharacters('0123456789X');
        $this->setChecksum('gtin');
    }

    /**
     * Allows X on length of 8 chars
     *
     * @param  string $value The barcode to check for allowed characters
     * @return bool
     */
    public function hasValidCharacters($value)
    {
        if (8 != mb_strlen($value)) {
            if (false !== mb_strpos($value, 'X')) {
                return false;
            }
        }

        return parent::hasValidCharacters($value);
    }

    /**
     * Validates the checksum
     *
     * @param  string $value The barcode to check the checksum for
     * @return bool
     */
    public function hasValidChecksum($value)
    {
        if (8 == mb_strlen($value)) {
            $this->setChecksum('issn');
        } else {
            $this->setChecksum('gtin');
        }

        return parent::hasValidChecksum($value);
    }

    /**
     * Validates the checksum ()
     * ISSN implementation (reversed mod11)
     *
     * @param  string $value The barcode to validate
     * @return bool
     */
    protected function issn($value)
    {
        $checksum = mb_substr($value, -1, 1);
        $values = str_split(mb_substr($value, 0, -1));
        $check = 0;
        $multi = 8;
        foreach ($values as $token) {
            if ('X' == $token) {
                $token = 10;
            }

            $check += ($token * $multi);
            --$multi;
        }

        $check %= 11;
        $check = (0 === $check ? 0 : (11 - $check));
        if ($check == $checksum) {
            return true;
        } elseif ((10 == $check) && ('X' == $checksum)) {
            return true;
        }

        return false;
    }
}
