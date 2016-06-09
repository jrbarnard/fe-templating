<?php
namespace Proto\Helpers;

/**
 * Class File
 * Helper for file operations
 * @package Proto\Helpers
 */
class File
{
    /**
     * Method to allow us to recursively delete directories
     * @param $directory
     * @param bool $recursive
     */
    public static function rmdir($directory, $recursive = false)
    {
        if (is_dir($directory)) {
            if ($recursive) {
                $objects = scandir($directory);
                foreach ($objects as $object) {
                    if ($object != "." && $object != "..") {
                        if (is_dir($directory."/".$object)) {
                            self::rmdir($directory."/".$object, $recursive);
                        } else {
                            unlink($directory."/".$object);
                        }
                    }
                }
            }
            rmdir($directory);
        }
    }

}