<?php
namespace Buddy;

/*
Reads the osTicket configuration file.

The file contains code to avoid being included by someone else, so we parse it instead.
The parser is very weak - it assumes the format of the sample config file with strings in single quotes
and no spaces around the , in the define.
*/

use ArrayAccess;

class Config implements arrayaccess
{
    private $config = array();

    function __construct()
    {
        $this->readConfig();
    }

    private function readConfig()
    {
        $contents = file_get_contents('ost-config.php');
        $lines = explode("\n", $contents);
        foreach($lines as $line) {
            $line = trim($line);
            if (substr($line, 0, 8) == "define('") {
                if (substr($line, -3) == "');") {
                    list($key, $value) = explode("','", substr($line, 8, -3), 2);
                } else {
                    list($key, $value) = explode("',", substr($line, 8, -2), 2);
                }
                $this->config[$key] = $value;
            }
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->config[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new \ErrorException("Config is read only");
    }

    public function offsetUnset($offset)
    {
        throw new \ErrorException("Config is read only");
    }
}