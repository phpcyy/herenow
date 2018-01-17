<?php

namespace Cache;

interface Cache
{
    public function set($key, $value, $timeout);

    public function get($key);

    public function expire($key, $timeout);

    public function ttl($key);

    public function del($key);

    public function ping();

    public function close();
}