<?php

namespace App\Helpers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Filesystem {
    /**
     * Find all files recursively in a directory
     *
     * @param string $path the directory to scan
     * @param array $validExtensions the extensions of files to allow
     * @return array the files that have been found
     */
    public static function findFiles(string $path, array $validExtensions = []) : array {
        $files = [];

        //If the path is a directory, iterate through it
        if(is_dir($path)) {
            $it = new RecursiveDirectoryIterator($path);

            foreach(new RecursiveIteratorIterator($it) as $file)
            {
                if (self::hasFileExtension($file, $validExtensions)) {
                    $files[] = $file;
                }
            }
        }
        //If the path is a file, check if it is a valid extension
        else if(is_file($path)) {
            if(self::hasFileExtension($path, $validExtensions)) {
                $files[] = $path;
            }
        }

        return $files;
    }

    /**
     * Gets the extension from the specified file
     *
     * @param string $filename the filename to get the extension from
     * @return string the extension, empty if not applicable
     */
    public static function getFileExtension(string $filename) : string {
        $extension = explode('.', $filename);

        if(count($extension) <= 1) {
            return '';
        }

        //Since a file can theoretically contain multiple dots, we only want the last element
        return strtolower($extension[count($extension) - 1]);
    }

    /**
     * Checks if the filename matches (one of) the extension(s)
     *
     * @param string $filename the filename to check
     * @param array $validExtensions the valid extension(s)
     * @return bool true if matching
     */
    public static function hasFileExtension(string $filename, array $validExtensions) : bool {
        $fileExt = self::getFileExtension($filename);

        return in_array($fileExt, $validExtensions);
    }
}
