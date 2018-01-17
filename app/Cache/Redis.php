<?php

namespace Cache;
class Redis implements Cache
{
    /**
     * @var \Redis
     */
    public $instance;

    public function __construct(Redis $redis)
    {
        $this->instance = $redis;
    }

    public function get($key)
    {
        return $this->instance->get($key);
    }

    public function set($key, $value, $timeout = 0)
    {
        return $this->instance->set($key, $value, $timeout);
    }

    public function del($key)
    {
        return $this->instance->del($key);
    }

    public function expire($key, $timeout)
    {
        return $this->instance->expire($key, $timeout);
    }

    public function ttl($key)
    {
        return $this->instance->ttl($key);
    }

    public function close()
    {
        return $this->instance->close();
    }

    public function ping()
    {
        return $this->instance->ping();
    }
}