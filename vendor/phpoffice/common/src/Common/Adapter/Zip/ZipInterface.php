<?php

namespace PhpOffice\Common\Adapter\Zip;

interface ZipInterface
{
    /**
     * Open a ZIP file archive
     * @param string $filename
     * @throws \Exception
     * @return $this
     */
    public function open($filename);

    /**
     * Close the active archive (opened or newly created)
     * @throws \Exception
     * @return $this
     */
    public function close();

    /**
     * Add a file to a ZIP archive using its contents
     * @param string $localname The name of the entry to create.
     * @param string $contents The contents to use to create the entry. It is used in a binary safe mode.
     * @throws \Exception
     * @return $this
     */
    public function addFromString($localname, $contents);
}
