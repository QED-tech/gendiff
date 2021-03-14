<?php

namespace Differ\Formatters;

function stylish(array $diff, $space = 0): string
{
    $result = '{' . PHP_EOL;
    $sp = str_repeat(" ", $space);
    $spCloseTag = str_repeat(" ", ($space === 0 ? 0 : $space - 2));
    foreach ($diff as $item) {
        $value = checkValueOnNested($item['value'] ?? '', $space + 4);
        $key = "{$item['key']}:";
        $oldValue = checkValueOnNested($item['oldValue'] ?? '', $space + 4);
        $newValue = checkValueOnNested($item['newValue'] ?? '', $space + 4);

        switch ($item['description']) {
            case 'parent':
                $result .= $sp . "  $key ";
                $result .= stylish($item['children'], $space + 4);
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

function checkValueOnNested($value, $space = 0): string
{
    if (!is_array($value)) {
        return $value;
    }
    $sp = str_repeat(" ", $space);
    $spCloseTag = str_repeat(" ", ($space === 0 ? 0 : $space - 2));
    $result = '{' . PHP_EOL;
    foreach ($value as $key => $val) {
        $val = checkValueOnNested($val, $space + 4);
        $result .= $sp . "  {$key}: {$val}" . PHP_EOL;
    }
    return $result . $spCloseTag . '}';
}
