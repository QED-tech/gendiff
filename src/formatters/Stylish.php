<?php

namespace Differ\Differ\Formatters;

const SPACE_COUNT = 4;

function stylish(array $diff, $space = 2): string
{
    [$sp, $spCloseTag] = getSpace($space);
    return '{' . PHP_EOL . implode(PHP_EOL, array_map(function ($item) use ($sp, $space) {
        $key = "{$item['key']}:";
        $value = parseValue($item['value'] ?? '', $space + SPACE_COUNT);
        $oldValue = parseValue($item['oldValue'] ?? '', $space + SPACE_COUNT);
        $newValue = parseValue($item['newValue'] ?? '', $space + SPACE_COUNT);
        switch ($item['description']) {
            case 'parent':
                return $sp . "  $key " . stylish($item['children'], $space + SPACE_COUNT);
            case 'deleted':
                return $sp . "- $key {$value}";
            case 'unchanged':
                return $sp . "  $key {$value}";
            case 'update':
                return $sp . "- $key {$oldValue}" . PHP_EOL . $sp . "+ $key {$newValue}";
            case 'added':
                return $sp . "+ $key {$value}";
            default:
                return '';
        }
        return '';
    }, $diff)) . PHP_EOL . $spCloseTag . '}';
}

function parseValue($value, $space = 0): string
{
    if (!is_array($value)) {
        return $value;
    }
    [$sp, $spCloseTag] = getSpace($space);
    return '{' . PHP_EOL . implode(PHP_EOL, array_map(function ($item) use ($value, $space, $sp) {
        $val = parseValue($item, $space + SPACE_COUNT);
        $key = array_search($item, $value, true);
        return $sp . "  {$key}: {$val}";
    }, $value)) . PHP_EOL . $spCloseTag . '}';
}

function getSpace(int $space): array
{
    return [
        str_repeat(" ", $space),
        str_repeat(" ", ($space === 0 ? 0 : $space - (SPACE_COUNT / 2))),
    ];
}
