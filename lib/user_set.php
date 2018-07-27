<?php
class EGV {
      static private $data = [];
      static private $init = false;

      static public function __get($name)
      {
            if (!self::$init) {
            $r = json_decode(file_get_contents("priv/settings.json"));
            if (json_last_error() !== JSON_ERROR_NONE) throw new Exception("Error Processing Settings", 2);      
            self::$init = true; 
            }

            if (isset(self::$data[$name])) return self::$data[$name];
            else throw new Exception("Error Reading Settings Proprety", 3);   
      }
}
