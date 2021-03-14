<?php

namespace Differ\Differ\Formatters;

const SPACE_COUNT = 4;

function stylish(array $diff, $space = 2): string
{
    $result = '{' . PHP_EOL;
    [$sp, $spCloseTag] = getSpace($space);
    foreach ($diff as $item) {
        $key = "{$item['key']}:";
        $value = checkValueStylish($item['value'] ?? '', $space + SPACE_COUNT);
        $oldValue = checkValueStylish($item['oldValue'] ?? '', $space + SPACE_COUNT);
        $newValue = checkValueStylish($item['newValue'] ?? '', $space + SPACE_COUNT);

        switch ($item['description']) {
            case 'parent':
                $result .= $sp . "  $key ";
                $result .= stylish($item['children'], $space + SPACE_COUNT);
                break;

            case 'deleted':
                $result .= $sp . "- $key {$value}" . PHP_EOL;
                break;
            case 'unchanged':
                $result .= $sp . "  $key {$value}" . PHP_EOL;
                break;
            case 'update':
                $result .= $sp . "- $key {$oldValue}" . PHP_EOL;
                $result .= $sp . "+ $key {$newValue}" . PHP_EOL;
                break;
            case 'added':
                $result .= $sp . "+ $key {$value}" . PHP_EOL;
                break;
        }
    }

    return $result . $spCloseTag . '}' . PHP_EOL;
}

function checkValueStylish($value, $space = 0): string
{
    if (!is_array($value)) {
        return $value;
    }

    [$sp, $spCloseTag] = getSpace($space);
    $result = '{' . PHP_EOL;
    foreach ($value as $key => $val) {
        $val = checkValueStylish($val, $space + SPACE_COUNT);
        $result .= $sp . "  {$key}: {$val}" . PHP_EOL;
    }
    return $result . $spCloseTag . '}';
}

function getSpace(int $space): array
{
    return [
        str_repeat(" ", $space),
        str_repeat(" ", ($space === 0 ? 0 : $space - (SPACE_COUNT / 2))),
    ];
}
