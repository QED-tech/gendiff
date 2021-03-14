<?php

namespace Differ\Formatters;

function plain(array $diff, string $parentKey = ''): string
{
    $result = '';

    foreach ($diff as $item) {
        $key = $parentKey === '' ? $item['key'] : $parentKey . "." . $item['key'];
        $value = checkValuePlain($item['value'] ?? '');
        $oldValue = checkValuePlain($item['oldValue'] ?? '');
        $newValue = checkValuePlain($item['newValue'] ?? '');
        switch ($item['description']) {
            case 'parent':
                $result .= plain($item['children'], $key);
                break;
            case 'deleted':
                $result .= "Property '$key' was removed" . PHP_EOL;
                break;
            case 'update':
                $result .= "Property '$key' was updated. From $oldValue to $newValue" . PHP_EOL;
                break;
            case 'added':
                $result .= "Property '$key' was added with value: $value" . PHP_EOL;
                break;
            default:
                continue 2;
        }
    }

    return $result;
}

function checkValuePlain($value): string
{
    return is_array($value) ? "[complex value]" : "'$value'";
}
