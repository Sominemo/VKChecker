<?php
class EGV {
      private static $data = [];
      private static $init = false;

      public static function Get($name)
      {
            if (!self::$init) {
            $r = json_decode(file_get_contents("priv/settings.json"), true);
            if (json_last_error() !== JSON_ERROR_NONE) throw new Exception("Error Processing Settings", 2);  
            foreach ($r as $k => $v) {
                  if (is_array($v) && isset($v['action'])) {
                        switch ($v['action']) {
                              case 'readFile':
                                    $r[$k] = file_get_contents($v['file']);
                                    break;
                        }
                  }
            }    
            self::$data = $r;
            self::$init = true; 
            }

            if (isset(self::$data[$name])) return self::$data[$name];
            else throw new Exception("Error Reading Settings Proprety", 3);   
      }
}
