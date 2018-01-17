<?php

namespace Cache;

class CacheManager
{
    public static function get()
    {
        $config = parse_ini_file("../Config/cache.ini");
    }
}