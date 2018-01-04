<?php

namespace Http;
class Response
{
    private $data;

    /**
     * Response constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function setContent($data)
    {
        $this->data = $data;
    }

    public function destroy()
    {
        $this->data = [];
    }

    public function append($data)
    {
        $this->data += $data;
    }

    public function setContentEncoding($encoding)
    {
        header("Content-encoding: $encoding");
    }

    public function send()
    {
        header("Content-type: application/json");
        echo json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }

    public function cookie($name, $string = null)
    {
        if ($string === null) {
            return $_COOKIE[$name] ?? null;
        }
        $_COOKIE[$name] = $string;
        return $string;
    }

    public function getContent()
    {
        return $this->data;
    }
}