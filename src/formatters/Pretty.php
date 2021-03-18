<?php

namespace Differ\Differ\Formatters;

function pretty(array $diff): string
{
    $result = json_encode($diff, JSON_PRETTY_PRINT);
    return $result === false ? '' : $result;
}
