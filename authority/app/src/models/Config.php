<?php
namespace Anka\Authority\Models;

/**
 * Parses Config and returns a specifig value 
 *
 * @author Flocki
 * 
 */
class Config{
	
    const KEY_SEPERATOR = '|';
    const CONFIG_FILE_PATH = '../config/config.php';
    
    /**
     * 
     * @param string $key   Key of the deired config entry.
     *                      Keyformat: key[|subkey1[|subkey2]].
     *                      Examples: 'key1', 'key1|key2'
     */
    public static function get($key){
        $value = null;
        if(is_string($key)){
            $config = require self::CONFIG_FILE_PATH;
            if(strpos($key, self::KEY_SEPERATOR) === false){
                if(isset($config[$key])){
                    $value = $config[$key];
                }
            }else{
                $split = explode(self::KEY_SEPERATOR, $key);
                for($i=0; $i<count($split); $i++){
                    $k = $split[$i];
                    if(isset($config[$k])){
                        $config = $config[$k];
                    }else{
                        $config = null;
                        break;
                    }
                }
                $value = $config;
            }
        }
        return $value;
    }
}