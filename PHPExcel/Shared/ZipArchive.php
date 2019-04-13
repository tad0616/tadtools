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
 * @package    PHPExcel_Shared_ZipArchive
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */
if (!defined('PCLZIP_TEMPORARY_DIR')) {
    define('PCLZIP_TEMPORARY_DIR', PHPExcel_Shared_File::sys_get_temp_dir() . DIRECTORY_SEPARATOR);
}
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/PCLZip/pclzip.lib.php';

/**
 * PHPExcel_Shared_ZipArchive
 *
 * @category   PHPExcel
 * @package    PHPExcel_Shared_ZipArchive
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Shared_ZipArchive
{
    /**	constants */
    const OVERWRITE = 'OVERWRITE';
    const CREATE = 'CREATE';

    /**
     * Temporary storage directory
     *
     * @var string
     */
    private $_tempDir;

    /**
     * Zip Archive Stream Handle
     *
     * @var string
     */
    private $_zip;

    /**
     * Open a new zip archive
     *
     * @param	string	$fileName	Filename for the zip archive
     * @return	bool
     */
    public function open($fileName)
    {
        $this->_tempDir = PHPExcel_Shared_File::sys_get_temp_dir();

        $this->_zip = new PclZip($fileName);

        return true;
    }

    /**
     * Close this zip archive
     */
    public function close()
    {
    }

    /**
     * Add a new file to the zip archive from a string of raw data.
     *
     * @param	string	$localname		Directory/Name of the file to add to the zip archive
     * @param	string	$contents		String of data to add to the zip archive
     */
    public function addFromString($localname, $contents)
    {
        $filenameParts = pathinfo($localname);

        $handle = fopen($this->_tempDir . '/' . $filenameParts['basename'], 'wb');
        fwrite($handle, $contents);
        fclose($handle);

        $res = $this->_zip->add(
            $this->_tempDir . '/' . $filenameParts['basename'],
            PCLZIP_OPT_REMOVE_PATH,
            $this->_tempDir,
            PCLZIP_OPT_ADD_PATH,
            $filenameParts['dirname']
                               );
        if (0 == $res) {
            throw new PHPExcel_Writer_Exception('Error zipping files : ' . $this->_zip->errorInfo(true));
        }

        unlink($this->_tempDir . '/' . $filenameParts['basename']);
    }

    /**
     * Find if given fileName exist in archive (Emulate ZipArchive locateName())
     *
     * @param        string        $fileName        Filename for the file in zip archive
     * @return        bool
     */
    public function locateName($fileName)
    {
        $list = $this->_zip->listContent();
        $listCount = count($list);
        $list_index = -1;
        for ($i = 0; $i < $listCount; ++$i) {
            if (mb_strtolower($list[$i]['filename']) == mb_strtolower($fileName) ||
                mb_strtolower($list[$i]['stored_filename']) == mb_strtolower($fileName)) {
                $list_index = $i;
                break;
            }
        }

        return ($list_index > -1);
    }

    /**
     * Extract file from archive by given fileName (Emulate ZipArchive getFromName())
     *
     * @param        string        $fileName        Filename for the file in zip archive
     * @return        string  $contents        File string contents
     */
    public function getFromName($fileName)
    {
        $list = $this->_zip->listContent();
        $listCount = count($list);
        $list_index = -1;
        for ($i = 0; $i < $listCount; ++$i) {
            if (mb_strtolower($list[$i]['filename']) == mb_strtolower($fileName) ||
                mb_strtolower($list[$i]['stored_filename']) == mb_strtolower($fileName)) {
                $list_index = $i;
                break;
            }
        }

        $extracted = '';
        if (-1 != $list_index) {
            $extracted = $this->_zip->extractByIndex($list_index, PCLZIP_OPT_EXTRACT_AS_STRING);
        } else {
            $filename = mb_substr($fileName, 1);
            $list_index = -1;
            for ($i = 0; $i < $listCount; ++$i) {
                if (mb_strtolower($list[$i]['filename']) == mb_strtolower($fileName) ||
                    mb_strtolower($list[$i]['stored_filename']) == mb_strtolower($fileName)) {
                    $list_index = $i;
                    break;
                }
            }
            $extracted = $this->_zip->extractByIndex($list_index, PCLZIP_OPT_EXTRACT_AS_STRING);
        }
        if ((is_array($extracted)) && (0 != $extracted)) {
            $contents = $extracted[0]['content'];
        }

        return $contents;
    }
}
