<?php

namespace Differ;

use Exception;

use function Differ\Formatters\getPlain;
use function Differ\parser;

function gendiff(string $firstFile, string $secondFile): string
{
    try {
        filesIsExists($firstFile, $secondFile);
    } catch (Exception $e) {
        return $e->getMessage();
    }

    [$firstAsArray, $secondAsArray] = getFilesAsSortArray($firstFile, $secondFile);
    $diff = getDiff($firstAsArray, $secondAsArray);
    return getPlain($diff);
}

function getDiff(array $firstList, array $secondList): array
{
    $keys = array_unique(array_merge(array_keys($firstList), array_keys($secondList)));
    $diff = array_map(function ($key) use ($firstList, $secondList) {
        return parser($key, $firstList, $secondList);
    }, $keys);
    return array_values($diff);
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
