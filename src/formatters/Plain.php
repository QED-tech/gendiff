<?php

namespace Differ\Formatters;

function getPlain(array $diff, $space = 0): string
{
    $plain = '{' . PHP_EOL;
    $sp = str_repeat(" ", $space);
    $spCloseTag = str_repeat(" ", $space === 0 ? 0 : $space - 2);
    foreach ($diff as $item) {
        $value = checkValueOnNested($item['value'] ?? '', $space + 4);
        $key = "{$item['key']}:";
        $oldValue = checkValueOnNested($item['oldValue'] ?? '', $space + 4);
        $newValue = checkValueOnNested($item['newValue'] ?? '', $space + 4);

        switch ($item['description']) {
            case 'parent':
                $plain .= $sp . "  $key ";
                $plain .= getPlain($item['children'], $space + 4);
                break;

            case 'deleted':
                $plain .= $sp . "- $key {$value}" . PHP_EOL;
                break;
            case 'unchanged':
                $plain .= $sp . "  $key {$value}" . PHP_EOL;
                break;
            case 'update':
                $plain .= $sp . "- $key {$oldValue}" . PHP_EOL;
                $plain .= $sp . "+ $key {$newValue}" . PHP_EOL;
                break;
            case 'added':
                $plain .= $sp . "+ $key {$value}" . PHP_EOL;
                break;
        }
    }

    return $plain . $spCloseTag . '}' . PHP_EOL;
}

function checkValueOnNested($value, $space = 0): string
{
    if (!is_array($value)) {
        return $value;
    }
    $sp = str_repeat(" ", $space);
    $spCloseTag = str_repeat(" ", $space === 0 ? 0 : $space - 2);
    $plain = '{' . PHP_EOL;
    foreach ($value as $key => $val) {
        $val = checkValueOnNested($val, $space + 4);
        $plain .= $sp . "  {$key}: {$val}" . PHP_EOL;
    }
    return $plain . $spCloseTag . '}';
}
