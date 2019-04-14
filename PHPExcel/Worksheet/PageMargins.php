<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/**
 * PHPExcel_Worksheet_PageMargins
 *
 * @category   PHPExcel
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Worksheet_PageMargins
{
    /**
     * Left
     *
     * @var float
     */
    private $_left = 0.7;

    /**
     * Right
     *
     * @var float
     */
    private $_right = 0.7;

    /**
     * Top
     *
     * @var float
     */
    private $_top = 0.75;

    /**
     * Bottom
     *
     * @var float
     */
    private $_bottom = 0.75;

    /**
     * Header
     *
     * @var float
     */
    private $_header = 0.3;

    /**
     * Footer
     *
     * @var float
     */
    private $_footer = 0.3;

    /**
     * Create a new PHPExcel_Worksheet_PageMargins
     */
    public function __construct()
    {
    }

    /**
     * Get Left
     *
     * @return float
     */
    public function getLeft()
    {
        return $this->_left;
    }

    /**
     * Set Left
     *
     * @param float $pValue
     * @return PHPExcel_Worksheet_PageMargins
     */
    public function setLeft($pValue)
    {
        $this->_left = $pValue;

        return $this;
    }

    /**
     * Get Right
     *
     * @return float
     */
    public function getRight()
    {
        return $this->_right;
    }

    /**
     * Set Right
     *
     * @param float $pValue
     * @return PHPExcel_Worksheet_PageMargins
     */
    public function setRight($pValue)
    {
        $this->_right = $pValue;

        return $this;
    }

    /**
     * Get Top
     *
     * @return float
     */
    public function getTop()
    {
        return $this->_top;
    }

    /**
     * Set Top
     *
     * @param float $pValue
     * @return PHPExcel_Worksheet_PageMargins
     */
    public function setTop($pValue)
    {
        $this->_top = $pValue;

        return $this;
    }

    /**
     * Get Bottom
     *
     * @return float
     */
    public function getBottom()
    {
        return $this->_bottom;
    }

    /**
     * Set Bottom
     *
     * @param float $pValue
     * @return PHPExcel_Worksheet_PageMargins
     */
    public function setBottom($pValue)
    {
        $this->_bottom = $pValue;

        return $this;
    }

    /**
     * Get Header
     *
     * @return float
     */
    public function getHeader()
    {
        return $this->_header;
    }

    /**
     * Set Header
     *
     * @param float $pValue
     * @return PHPExcel_Worksheet_PageMargins
     */
    public function setHeader($pValue)
    {
        $this->_header = $pValue;

        return $this;
    }

    /**
     * Get Footer
     *
     * @return float
     */
    public function getFooter()
    {
        return $this->_footer;
    }

    /**
     * Set Footer
     *
     * @param float $pValue
     * @return PHPExcel_Worksheet_PageMargins
     */
    public function setFooter($pValue)
    {
        $this->_footer = $pValue;

        return $this;
    }

    /**
     * Implement PHP __clone to create a deep clone, not just a shallow copy.
     */
    public function __clone()
    {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (is_object($value)) {
                $this->$key = clone $value;
            } else {
                $this->$key = $value;
            }
        }
    }
}
