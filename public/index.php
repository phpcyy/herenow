<?php
require_once "../vendor/autoload.php";
try {
    $app = new App();
    $app->dispatch()->response();
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}
