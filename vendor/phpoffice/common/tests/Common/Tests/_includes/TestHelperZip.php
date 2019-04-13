<?php

namespace PhpOffice\Common\Tests;

class TestHelperZip
{
    public static function assertFileExists($fileZip, $path)
    {
        $oZip = new \ZipArchive();
        if (true !== $oZip->open($fileZip)) {
            return false;
        }
        if (false === $oZip->statName($path)) {
            return false;
        }

        return true;
    }

    public static function assertFileContent($fileZip, $path, $content)
    {
        $oZip = new \ZipArchive();
        if (true !== $oZip->open($fileZip)) {
            return false;
        }
        $zipFileContent = $oZip->getFromName($path);
        if (false === $zipFileContent) {
            return false;
        }
        if ($zipFileContent != $content) {
            return false;
        }

        return true;
    }
}
