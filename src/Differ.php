<?php

namespace Differ;

use Exception;

use function Differ\Formatters\getPlain;
use function Differ\parser;

function gendiff(string $firstFile, string $secondFile): string
{
    try {
        filesIsExists([$firstFile, $secondFile]);
    } catch (Exception $e) {
        return $e->getMessage();
    }

    [$firstAsArray, $secondAsArray] = getFiles($firstFile, $secondFile);
    return getPlain(getDiff($firstAsArray, $secondAsArray));
}

function getDiff(array $firstList, array $secondList): array
{
    $keys = getAllUniqueKeys($firstList, $secondList);
    return array_values(array_map(function ($key) use ($firstList, $secondList) {
        if (is_array($firstList[$key] ?? null) && is_array($secondList[$key] ?? null)) {
            return [
                'key' => $key,
                'description' => 'parent',
                'children' => getDiff($firstList[$key], $secondList[$key]),
            ];
        }
        return parser($key, $firstList, $secondList);
    }, $keys));
}

function getAllUniqueKeys(array $firstList, array $secondList): array
{
    $keys = array_unique(
        array_merge(
            array_keys($firstList),
            array_keys($secondList)
        )
    );
    asort($keys, SORT_STRING);
    return $keys;
}

/**
 * @throws Exception
 */
function filesIsExists(array $files): void
{
    foreach ($files as $file) {
        if (!file_exists($file)) {
            throw new Exception(sprintf("%s file not exists", $file));
        }
    }
}
