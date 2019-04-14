<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link           http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright      Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license        http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Stdlib\Hydrator\Filter;

class HasFilter implements FilterInterface
{
    public function filter($property)
    {
        $pos = mb_strpos($property, '::');
        if (false !== $pos) {
            $pos += 2;
        } else {
            $pos = 0;
        }

        if ('has' === mb_substr($property, $pos, 3)) {
            return true;
        }

        return false;
    }
}
