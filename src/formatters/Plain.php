<?php

namespace Differ\Differ\Formatters;

use function Functional\flatten;

function plain(array $diff, string $parentKey = ''): string
{
    return array_reduce(array_filter(flatten(array_map(function ($item) use ($parentKey) {
        $key = $parentKey === '' ? $item['key'] : $parentKey . "." . $item['key'];
        $value = checkValuePlain($item['value'] ?? '');
        $oldValue = checkValuePlain($item['oldValue'] ?? '');
        $newValue = checkValuePlain($item['newValue'] ?? '');
        switch ($item['description']) {
            case 'parent':
                return plain($item['children'], $key);
                break;
            case 'deleted':
                return "Property '$key' was removed";
                break;
            case 'update':
                return "Property '$key' was updated. From $oldValue to $newValue";
                break;
            case 'added':
                return "Property '$key' was added with value: $value";
                break;
            default:
                break;
        }
    }, $diff))), function ($acc, $item) {
        return $acc .= trim($item) . PHP_EOL;
    }, '');
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
