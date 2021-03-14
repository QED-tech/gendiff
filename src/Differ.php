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

    [$firstAsArray, $secondAsArray] = getFilesAsSortArray($firstFile, $secondFile);
    return getPlain(getDiff($firstAsArray, $secondAsArray));
}

function getDiff(array $firstList, array $secondList): array
{
    $keys = array_unique(array_merge(array_keys($firstList), array_keys($secondList)));
    return array_values(array_map(function ($key) use ($firstList, $secondList) {
        return parser($key, $firstList, $secondList);
    }, $keys));
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
