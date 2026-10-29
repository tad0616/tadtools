<?php

namespace XoopsModules\Tadtools;

/**
 * 讀取 XOOPS logger 寫入的致命錯誤紀錄（每行一筆 JSON）。
 * 寫入端在 class/logger/xoopslogger.php 的 handleError()，兩邊的檔案路徑必須一致。
 */
class ErrorLog
{
    public static function path()
    {
        return XOOPS_VAR_PATH . '/logs/tadtools_error.log';
    }

    // 主檔加上輪替的舊檔 .1、.2 ...，順序由新到舊
    public static function files()
    {
        $files = [self::path()];
        $old   = [];
        foreach ((array) glob(self::path() . '.*') as $file) {
            $n = substr($file, strlen(self::path()) + 1);
            if (ctype_digit($n)) {
                $old[(int) $n] = $file;
            }
        }
        ksort($old);

        return array_merge($files, array_values($old));
    }

    public static function isValidId($id)
    {
        return (bool) preg_match('/^[a-f0-9]{16}$/', (string) $id);
    }

    // 回傳由新到舊的紀錄；有指定錯誤編號時只回傳符合者
    public static function search($error_id = '', $limit = 50)
    {
        $records = [];
        // 先讀目前的紀錄檔，再依序讀輪替後的舊檔
        foreach (self::files() as $file) {
            if (!is_readable($file)) {
                continue;
            }
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
            foreach (array_reverse($lines) as $line) {
                $record = json_decode($line, true);
                if (!is_array($record)) {
                    continue;
                }
                if ('' !== $error_id && ($record['id'] ?? '') !== $error_id) {
                    continue;
                }
                $records[] = $record;
                if (count($records) >= $limit) {
                    break 2;
                }
            }
        }

        return $records;
    }

    public static function clear()
    {
        foreach (self::files() as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }
}
