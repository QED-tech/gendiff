<?php

namespace Differ\Differ;

function parser(string $key, array $firstList, array $secondList): array
{
    $valueFirst = boolToString($firstList[$key] ?? null);
    $valueSecond = boolToString($secondList[$key] ?? null);

    if (!array_key_exists($key, $secondList)) {
        return [
            'key' => $key,
            'value' => $valueFirst,
            'changed' => true,
            'description' => 'deleted',
        ];
    }

    if ($valueFirst === $valueSecond) {
        return [
            'key' => $key,
            'value' => $valueFirst,
            'changed' => false,
            'description' => 'unchanged',
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
