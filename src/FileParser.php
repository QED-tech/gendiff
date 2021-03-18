<?php

namespace Differ\Differ;

use Symfony\Component\Yaml\Yaml;

function getFiles(string $firstFilePath, string $secondFilePath): array
{
    $first = getAsArrayByExtension($firstFilePath);
    $second = getAsArrayByExtension($secondFilePath);
    return [$first, $second];
}

function getAsArrayByExtension(string $file): array
{
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $content = file_get_contents($file) === false ? '' : file_get_contents($file);
    switch ($extension) {
        case 'json':
            return json_decode($content, true);
        case 'yml':
            return Yaml::parse($content);
        case 'yaml':
            return Yaml::parse($content);
        default:
            throw new \Exception("Format '$extension' is unknown for parsing");
    }
}
