<?php

function p(...$data)
{
    foreach ($data as $v) {
        var_dump($v);
    }
    exit;
}