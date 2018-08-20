<?php

class Language {
    const List = [
        "en" => 1,
        "ru" => "en"
    ];

    private static $init = false;

    private static $clisteners = [];

    private static $langLib = [];

    private static $current = self::List[0];

    public function Set($a = "en") {
        if (!array_key_exists($a, self::List)) {self::Set(self::List[0]); return;}

        if (is_string(self::List[$a])) self::Set(self::List[$a]);
        else self::$current = $a;

        self::Update();
        self::$init = true;
    }

    public static function Update() {
        $l = file_get_contents('langs/'.self::$current.'.json');
        $l = json_decode($l, true);

        if ($l !== null) DevLog::w("Language: $l has been loaded or updated");
        else {
            DevLog::w("Language: $l has failed to be parsed as JSON");
            self::$current = false;
            return;
        }

        self::$langLib = $l;
        foreach (self::$clisteners as $v) {
            $v(self::$current);
        }
    }

    public static function addKey($a, $b, $c = false) {
        if (array_key_exists($a, self::$langLib) || !is_string($b)) return false;
        self::$langLib[$a] = $b;
        if ($c) self::$clisteners[] = $c;
    }

    public static function GetLangLib() {
        return self::$langLib;
    }

    public static function Get() {
        return self::$current;
    }
}

function __($i) {
    if (!array_key_exists($i, Language::GetLangLib())) return "[$i]";
    else return Language::GetLangLib()[$i];
}