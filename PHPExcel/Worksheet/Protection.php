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
 * PHPExcel_Worksheet_Protection
 *
 * @category   PHPExcel
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Worksheet_Protection
{
    /**
     * Sheet
     *
     * @var bool
     */
    private $_sheet = false;

    /**
     * Objects
     *
     * @var bool
     */
    private $_objects = false;

    /**
     * Scenarios
     *
     * @var bool
     */
    private $_scenarios = false;

    /**
     * Format cells
     *
     * @var bool
     */
    private $_formatCells = false;

    /**
     * Format columns
     *
     * @var bool
     */
    private $_formatColumns = false;

    /**
     * Format rows
     *
     * @var bool
     */
    private $_formatRows = false;

    /**
     * Insert columns
     *
     * @var bool
     */
    private $_insertColumns = false;

    /**
     * Insert rows
     *
     * @var bool
     */
    private $_insertRows = false;

    /**
     * Insert hyperlinks
     *
     * @var bool
     */
    private $_insertHyperlinks = false;

    /**
     * Delete columns
     *
     * @var bool
     */
    private $_deleteColumns = false;

    /**
     * Delete rows
     *
     * @var bool
     */
    private $_deleteRows = false;

    /**
     * Select locked cells
     *
     * @var bool
     */
    private $_selectLockedCells = false;

    /**
     * Sort
     *
     * @var bool
     */
    private $_sort = false;

    /**
     * AutoFilter
     *
     * @var bool
     */
    private $_autoFilter = false;

    /**
     * Pivot tables
     *
     * @var bool
     */
    private $_pivotTables = false;

    /**
     * Select unlocked cells
     *
     * @var bool
     */
    private $_selectUnlockedCells = false;

    /**
     * Password
     *
     * @var string
     */
    private $_password = '';

    /**
     * Create a new PHPExcel_Worksheet_Protection
     */
    public function __construct()
    {
    }

    /**
     * Is some sort of protection enabled?
     *
     * @return bool
     */
    public function isProtectionEnabled()
    {
        return 	$this->_sheet ||
                $this->_objects ||
                $this->_scenarios ||
                $this->_formatCells ||
                $this->_formatColumns ||
                $this->_formatRows ||
                $this->_insertColumns ||
                $this->_insertRows ||
                $this->_insertHyperlinks ||
                $this->_deleteColumns ||
                $this->_deleteRows ||
                $this->_selectLockedCells ||
                $this->_sort ||
                $this->_autoFilter ||
                $this->_pivotTables ||
                $this->_selectUnlockedCells;
    }

    /**
     * Get Sheet
     *
     * @return bool
     */
    public function getSheet()
    {
        return $this->_sheet;
    }

    /**
     * Set Sheet
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setSheet($pValue = false)
    {
        $this->_sheet = $pValue;

        return $this;
    }

    /**
     * Get Objects
     *
     * @return bool
     */
    public function getObjects()
    {
        return $this->_objects;
    }

    /**
     * Set Objects
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setObjects($pValue = false)
    {
        $this->_objects = $pValue;

        return $this;
    }

    /**
     * Get Scenarios
     *
     * @return bool
     */
    public function getScenarios()
    {
        return $this->_scenarios;
    }

    /**
     * Set Scenarios
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setScenarios($pValue = false)
    {
        $this->_scenarios = $pValue;

        return $this;
    }

    /**
     * Get FormatCells
     *
     * @return bool
     */
    public function getFormatCells()
    {
        return $this->_formatCells;
    }

    /**
     * Set FormatCells
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setFormatCells($pValue = false)
    {
        $this->_formatCells = $pValue;

        return $this;
    }

    /**
     * Get FormatColumns
     *
     * @return bool
     */
    public function getFormatColumns()
    {
        return $this->_formatColumns;
    }

    /**
     * Set FormatColumns
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setFormatColumns($pValue = false)
    {
        $this->_formatColumns = $pValue;

        return $this;
    }

    /**
     * Get FormatRows
     *
     * @return bool
     */
    public function getFormatRows()
    {
        return $this->_formatRows;
    }

    /**
     * Set FormatRows
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setFormatRows($pValue = false)
    {
        $this->_formatRows = $pValue;

        return $this;
    }

    /**
     * Get InsertColumns
     *
     * @return bool
     */
    public function getInsertColumns()
    {
        return $this->_insertColumns;
    }

    /**
     * Set InsertColumns
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setInsertColumns($pValue = false)
    {
        $this->_insertColumns = $pValue;

        return $this;
    }

    /**
     * Get InsertRows
     *
     * @return bool
     */
    public function getInsertRows()
    {
        return $this->_insertRows;
    }

    /**
     * Set InsertRows
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setInsertRows($pValue = false)
    {
        $this->_insertRows = $pValue;

        return $this;
    }

    /**
     * Get InsertHyperlinks
     *
     * @return bool
     */
    public function getInsertHyperlinks()
    {
        return $this->_insertHyperlinks;
    }

    /**
     * Set InsertHyperlinks
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setInsertHyperlinks($pValue = false)
    {
        $this->_insertHyperlinks = $pValue;

        return $this;
    }

    /**
     * Get DeleteColumns
     *
     * @return bool
     */
    public function getDeleteColumns()
    {
        return $this->_deleteColumns;
    }

    /**
     * Set DeleteColumns
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setDeleteColumns($pValue = false)
    {
        $this->_deleteColumns = $pValue;

        return $this;
    }

    /**
     * Get DeleteRows
     *
     * @return bool
     */
    public function getDeleteRows()
    {
        return $this->_deleteRows;
    }

    /**
     * Set DeleteRows
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setDeleteRows($pValue = false)
    {
        $this->_deleteRows = $pValue;

        return $this;
    }

    /**
     * Get SelectLockedCells
     *
     * @return bool
     */
    public function getSelectLockedCells()
    {
        return $this->_selectLockedCells;
    }

    /**
     * Set SelectLockedCells
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setSelectLockedCells($pValue = false)
    {
        $this->_selectLockedCells = $pValue;

        return $this;
    }

    /**
     * Get Sort
     *
     * @return bool
     */
    public function getSort()
    {
        return $this->_sort;
    }

    /**
     * Set Sort
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setSort($pValue = false)
    {
        $this->_sort = $pValue;

        return $this;
    }

    /**
     * Get AutoFilter
     *
     * @return bool
     */
    public function getAutoFilter()
    {
        return $this->_autoFilter;
    }

    /**
     * Set AutoFilter
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setAutoFilter($pValue = false)
    {
        $this->_autoFilter = $pValue;

        return $this;
    }

    /**
     * Get PivotTables
     *
     * @return bool
     */
    public function getPivotTables()
    {
        return $this->_pivotTables;
    }

    /**
     * Set PivotTables
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setPivotTables($pValue = false)
    {
        $this->_pivotTables = $pValue;

        return $this;
    }

    /**
     * Get SelectUnlockedCells
     *
     * @return bool
     */
    public function getSelectUnlockedCells()
    {
        return $this->_selectUnlockedCells;
    }

    /**
     * Set SelectUnlockedCells
     *
     * @param bool $pValue
     * @return PHPExcel_Worksheet_Protection
     */
    public function setSelectUnlockedCells($pValue = false)
    {
        $this->_selectUnlockedCells = $pValue;

        return $this;
    }

    /**
     * Get Password (hashed)
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Set Password
     *
     * @param string 	$pValue
     * @param bool 	$pAlreadyHashed If the password has already been hashed, set this to true
     * @return PHPExcel_Worksheet_Protection
     */
    public function setPassword($pValue = '', $pAlreadyHashed = false)
    {
        if (!$pAlreadyHashed) {
            $pValue = PHPExcel_Shared_PasswordHasher::hashPassword($pValue);
        }
        $this->_password = $pValue;

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
