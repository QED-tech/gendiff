<?php

namespace Differ\Differ\Formatters;

function plain(array $diff, string $parentKey = ''): string
{
    $result = '';

    array_map(function ($item) use (&$result, $parentKey) {
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
                break;
        }
    }, $diff);

    return $result;
}

/**
 *
 * @param mixed $value
 * @return mixed
 */
function checkValuePlain($value)
{
    if ($value === "true" || $value === "false" || $value === "null") {
        return $value;
    }

    if (is_string($value)) {
        return "'$value'";
    }

    if (is_array($value)) {
        return "[complex value]";
    }

    return $value;
}
