<?php
/**
 * PHPWord
 *
 * Copyright (c) 2011 PHPWord
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
 * @category   PHPWord
 * @package    PHPWord
 * @copyright  Copyright (c) 010 PHPWord
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    Beta 0.6.3, 08.07.2011
 */

/** Register new zip wrapper */
PHPWord_Shared_ZipStreamWrapper::register();

class PHPWord_Shared_ZipStreamWrapper
{
    /**
     * Internal ZipAcrhive
     *
     * @var ZipAcrhive
     */
    private $_archive;

    /**
     * Filename in ZipAcrhive
     *
     * @var string
     */
    private $_fileNameInArchive = '';

    /**
     * Position in file
     *
     * @var int
     */
    private $_position = 0;

    /**
     * Data
     *
     * @var mixed
     */
    private $_data = '';

    /**
     * Register wrapper
     */
    public static function register()
    {
        @stream_wrapper_unregister('zip');
        @stream_wrapper_register('zip', __CLASS__);
    }

    /**
     * Open stream
     * @param mixed $path
     * @param mixed $mode
     * @param mixed $options
     * @param mixed $opened_path
     */
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        // Check for mode
        if ('r' != $mode[0]) {
            throw new Exception('Mode ' . $mode . ' is not supported. Only read mode is supported.');
        }

        // Parse URL
        $url = @parse_url($path);

        // Fix URL
        if (!is_array($url)) {
            $url['host'] = mb_substr($path, mb_strlen('zip://'));
            $url['path'] = '';
        }
        if (false !== mb_strpos($url['host'], '#')) {
            if (!isset($url['fragment'])) {
                $url['fragment'] = mb_substr($url['host'], mb_strpos($url['host'], '#') + 1) . $url['path'];
                $url['host'] = mb_substr($url['host'], 0, mb_strpos($url['host'], '#'));
                unset($url['path']);
            }
        } else {
            $url['host'] = $url['host'] . $url['path'];
            unset($url['path']);
        }

        // Open archive
        $this->_archive = new ZipArchive();
        $this->_archive->open($url['host']);

        $this->_fileNameInArchive = $url['fragment'];
        $this->_position = 0;
        $this->_data = $this->_archive->getFromName($this->_fileNameInArchive);

        return true;
    }

    /**
     * Stat stream
     */
    public function stream_stat()
    {
        return $this->_archive->statName($this->_fileNameInArchive);
    }

    /**
     * Read stream
     * @param mixed $count
     */
    public function stream_read($count)
    {
        $ret = mb_substr($this->_data, $this->_position, $count);
        $this->_position += mb_strlen($ret);

        return $ret;
    }

    /**
     * Tell stream
     */
    public function stream_tell()
    {
        return $this->_position;
    }

    /**
     * EOF stream
     */
    public function stream_eof()
    {
        return $this->_position >= mb_strlen($this->_data);
    }

    /**
     * Seek stream
     * @param mixed $offset
     * @param mixed $whence
     */
    public function stream_seek($offset, $whence)
    {
        switch ($whence) {
            case SEEK_SET:
                if ($offset < mb_strlen($this->_data) && $offset >= 0) {
                    $this->_position = $offset;

                    return true;
                }

                     return false;
                break;
            case SEEK_CUR:
                if ($offset >= 0) {
                    $this->_position += $offset;

                    return true;
                }

                     return false;
                break;
            case SEEK_END:
                if (mb_strlen($this->_data) + $offset >= 0) {
                    $this->_position = mb_strlen($this->_data) + $offset;

                    return true;
                }

                     return false;
                break;
            default:
                return false;
        }
    }
}
