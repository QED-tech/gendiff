<?php

namespace Differ\Differ;

use Exception;

function gendiff(string $firstFile, string $secondFile): string
{
    try {
        filesIsExists($firstFile, $secondFile);
    } catch (Exception $e) {
        return $e->getMessage();
    }
    $firstAsArray = json_decode(file_get_contents($firstFile), true);
    $secondAsArray = json_decode(file_get_contents($secondFile), true);
    keySort($firstAsArray, $secondAsArray);
    return getDiff($firstAsArray, $secondAsArray);
}

function getDiff(array $firstList, array $secondList)
{
    $diff = '{' . PHP_EOL;

    foreach (array_keys($firstList) as $key) {

        $valueFirst = boolToString($firstList[$key]);
        $valueSecond = boolToString($secondList[$key] ?? '');

        if (!array_key_exists($key, $secondList)) {
            $diff .= "- {$key}: {$valueFirst}" . PHP_EOL;
        }

        if (
            array_key_exists($key, $secondList) &&
            $firstList[$key] === $secondList[$key]
        ) {
            $diff .= "  {$key}: {$valueFirst}" . PHP_EOL;
        }

        if (
            array_key_exists($key, $secondList) &&
            $firstList[$key] !== $secondList[$key]
        ) {
            $diff .= "- {$key}: {$valueFirst}" . PHP_EOL;
            $diff .= "+ {$key}: {$valueSecond}" . PHP_EOL;
        }
        unset($secondList[$key]);
    }

    if (count($secondList) > 0) {
        foreach (array_keys($secondList) as $key) {
            $value = boolToString($secondList[$key] ?? '');
            $diff .= "+ {$key}: {$value}" . PHP_EOL;
        }
    }

    return $diff . '}';
}

function boolToString($value): string
{
    if ($value === false) {
        return 'false';
    }

    if ($value === true) {
        return 'true';
    }

    return $value;
}

function keySort(array &$first, array &$second): void
{
    ksort($first, SORT_STRING);
    ksort($second, SORT_STRING);
}

function filesIsExists(string $firstFile, string $secondFile): void
{
    if (!file_exists($firstFile)) {
        throw new Exception(sprintf("%s file not exists", $firstFile));
    }

    if (!file_exists($secondFile)) {
        throw new Exception(sprintf("%s file not exists", $firstFile));
    }
}
