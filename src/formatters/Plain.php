<?php

namespace Differ\Differ\Formatters;

use function Functional\flatten;

function plain(array $diff, string $parentKey = ''): string
{
    return implode(PHP_EOL, array_filter(flatten(array_map(function ($item) use ($parentKey) {
        $key = $parentKey === '' ? $item['key'] : $parentKey . "." . $item['key'];
        $value = checkValuePlain($item['value'] ?? '');
        $oldValue = checkValuePlain($item['oldValue'] ?? '');
        $newValue = checkValuePlain($item['newValue'] ?? '');
        switch ($item['description']) {
            case 'parent':
                return plain($item['children'], $key);
            case 'deleted':
                return "Property '$key' was removed";
            case 'update':
                return "Property '$key' was updated. From $oldValue to $newValue";
            case 'added':
                return "Property '$key' was added with value: $value";
            default:
                return '';
        }
        return '';
    }, $diff))));
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
