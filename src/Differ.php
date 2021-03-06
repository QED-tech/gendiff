<?php

namespace Differ\Differ;

use function Differ\Differ\Formatters\plain;
use function Differ\Differ\Formatters\pretty;
use function Differ\Differ\Formatters\stylish;

function genDiff(string $firstFile, string $secondFile, string $format = 'stylish'): string
{
    [$firstAsArray, $secondAsArray] = getFiles($firstFile, $secondFile);
    return formatted($format, getDiff($firstAsArray, $secondAsArray));
}

function getDiff(array $firstList, array $secondList): array
{
    $keys = getAllUniqueKeys($firstList, $secondList);
    $diff = array_map(function ($key) use ($firstList, $secondList) {
        $valueFirst = boolToString($firstList[$key] ?? null);
        $valueSecond = boolToString($secondList[$key] ?? null);
        if (is_array($valueFirst) && is_array($valueSecond)) {
            return [
                'key' => $key,
                'description' => 'parent',
                'children' => getDiff($valueFirst, $valueSecond),
            ];
        }

        if (!array_key_exists($key, $secondList)) {
            return [
                'key' => $key,
                'value' => $valueFirst,
                'changed' => true,
                'description' => 'deleted',
            ];
        }

        if (!array_key_exists($key, $firstList)) {
            return [
                'key' => $key,
                'value' => $valueSecond,
                'changed' => true,
                'description' => 'added',
            ];
        }

        if ($valueFirst !== $valueSecond) {
            return [
                'key' => $key,
                'oldValue' => $valueFirst,
                'newValue' => $valueSecond,
                'changed' => true,
                'description' => 'update',
            ];
        }

        return [
            'key' => $key,
            'value' => $valueFirst,
            'changed' => false,
            'description' => 'unchanged',
        ];
    }, $keys);

    return array_values($diff);
}

/**
 *
 * @param mixed $value
 * @return mixed
 */
function boolToString($value)
{
    if ($value === false) {
        return 'false';
    }

    if ($value === true) {
        return 'true';
    }

    if ($value === null) {
        return 'null';
    }

    return $value;
}

function getAllUniqueKeys(array $firstList, array $secondList): array
{
    $collection = collect(array_unique(
        array_merge(
            array_keys($firstList),
            array_keys($secondList)
        )
    ));
    $sorted = $collection->sort(SORT_STRING);
    return $sorted->all();
}

function formatted(string $format, array $diff): string
{
    switch ($format) {
        case 'stylish':
            return stylish($diff);
        case 'plain':
            return trim(plain($diff));
        case 'json':
            return pretty($diff);
        default:
            return trim(stylish($diff));
    }
}
