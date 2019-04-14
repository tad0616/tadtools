<?php

namespace PhpOffice\Common\Adapter\Zip;

use ZipArchive;

class ZipArchiveAdapter implements ZipInterface
{
    /**
     * @var ZipArchive
     */
    protected $oZipArchive;

    /**
     * @var string
     */
    protected $filename;

    public function open($filename)
    {
        $this->filename = $filename;
        $this->oZipArchive = new ZipArchive();

        if (true === $this->oZipArchive->open($this->filename, ZipArchive::OVERWRITE)) {
            return $this;
        }
        if (true === $this->oZipArchive->open($this->filename, ZipArchive::CREATE)) {
            return $this;
        }
        throw new \Exception("Could not open $this->filename for writing.");
    }

    public function close()
    {
        if (false === $this->oZipArchive->close()) {
            throw new \Exception("Could not close zip file $this->filename.");
        }

        return $this;
    }

    public function addFromString($localname, $contents)
    {
        if (false === $this->oZipArchive->addFromString($localname, $contents)) {
            throw new \Exception('Error zipping files : ' . $localname);
        }

        return $this;
    }
}
