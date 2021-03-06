<?php
namespace Ouzo\Utilities;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class DeleteDirectory
 * @package Ouzo\Utilities
 */
class DeleteDirectory
{
    /**
     * Recursively deletes directories and files.
     *
     * @param string $path
     */
    public static function recursive($path)
    {
        if (is_dir($path)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($iterator as $file) {
                self::_deleteFile($file);
            }
            rmdir($path);
        }
    }

    private static function _deleteFile(SplFileInfo $file)
    {
        if (in_array($file->getBasename(), array('.', '..'))) {
            return;
        } elseif ($file->isDir()) {
            rmdir($file->getPathname());
        } elseif ($file->isFile() || $file->isLink()) {
            unlink($file->getPathname());
        }
    }
}
