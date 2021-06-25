<?php

namespace App\Helpers;

use Exception;
use Symfony\Component\Finder\Finder;

class Filesystem
{
    /**
     * Find all files recursively in a directory
     *
     * @param  string  $path  the directory to scan
     * @param  string  $filter  the extensions of files to allow, can be regex
     * @return array the files that have been found
     * @throws Exception
     */
    public static function findFiles(string $path, string $filter = ''): array
    {
        $files = [];

        //If the path is a directory, iterate through it
        if (is_dir($path)) {
            $it = Finder::create()->files()->in($path);

            if ($filter !== '') {
                $it->name($filter);
            }

            $it->getIterator();

            foreach ($it as $file) {
                $files[] = $file;
            }
        } //If the path is a file, check if it is a valid extension
        else {
            throw new Exception("Provided path is not a directory");
        }

        return $files;
    }

    /**
     * Checks if the filename matches (one of) the extension(s)
     *
     * @param  string  $filename  the filename to check
     * @param  array  $validExtensions  the valid extension(s)
     * @return bool true if matching
     */
    public static function hasFileExtension(string $filename, array $validExtensions): bool
    {
        $fileExt = self::getFileExtension($filename);

        return in_array($fileExt, $validExtensions);
    }

    /**
     * Gets the extension from the specified file
     *
     * @param  string  $filename  the filename to get the extension from
     * @return string the extension, empty if not applicable
     */
    public static function getFileExtension(string $filename): string
    {
        $extension = explode('.', $filename);

        if (count($extension) <= 1) {
            return '';
        }

        //Since a file can theoretically contain multiple dots, we only want the last element
        return strtolower($extension[count($extension) - 1]);
    }

    /**
     * Corrects the Directory Separators of a path to unix style
     *
     * @param  string  $path
     * @return string
     */
    public static function correctDS(string $path): string
    {
        return str_replace('\\', '/', $path);
    }

    public static function isSymbolicLink($target)
    {
        if (defined('PHP_WINDOWS_VERSION_BUILD')) {
            if (file_exists($target) && readlink($target) != $target) {
                return true;
            }
        } elseif (is_link($target)) {
            return true;
        }
        return false;
    }
}
