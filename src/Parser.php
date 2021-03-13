<?php

namespace Differ;

function parser(string $key, array $firstList, array $secondList): array
{
    $valueFirst = boolToString($firstList[$key] ?? '');
    $valueSecond = boolToString($secondList[$key] ?? '');

    if (!array_key_exists($key, $secondList)) {
        return [
            'key' => $key,
            'value' => $valueFirst,
            'changed' => true,
            'description' => 'deleted',
        ];
    }

    if (
        array_key_exists($key, $secondList) &&
        $valueFirst === $valueSecond
    ) {
        return [
            'key' => $key,
            'value' => $valueFirst,
            'changed' => false,
            'description' => 'unchanged',
        ];
    }

    if (
        array_key_exists($key, $secondList) &&
        !array_key_exists($key, $firstList)
    ) {
        return [
            'key' => $key,
            'value' => $valueSecond,
            'changed' => true,
            'description' => 'added',
        ];
    }

    if (
        array_key_exists($key, $secondList) &&
        $valueFirst !== $valueSecond
    ) {
        return [
            'key' => $key,
            'oldValue' => $valueFirst,
            'newValue' => $valueSecond,
            'changed' => true,
            'description' => 'update',
        ];
    }
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
