<?php

namespace Differ\Formatters;

function getPlain(array $diff): string
{
    $plain = '{' . PHP_EOL;

    foreach ($diff as $item) {
        switch ($item['description']) {
            case 'deleted':
                $plain .= "- {$item['key']}: {$item['value']}" . PHP_EOL;
                break;
            case 'unchanged':
                $plain .= "  {$item['key']}: {$item['value']}" . PHP_EOL;
                break;
            case 'update':
                $plain .= "- {$item['key']}: {$item['oldValue']}" . PHP_EOL;
                $plain .= "+ {$item['key']}: {$item['newValue']}" . PHP_EOL;
                break;
            case 'added':
                $plain .= "+ {$item['key']}: {$item['value']}" . PHP_EOL;
                break;
        }
    }

    return $plain . '}' . PHP_EOL;
}
