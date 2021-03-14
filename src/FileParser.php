<?php

namespace Differ;

use Symfony\Component\Yaml\Yaml;

function getFiles(string $firstFilePath, string $secondFilePath): array
{
    [$first, $second] = getAsArrayByExtension([$firstFilePath, $secondFilePath]);
    return [$first, $second];
}

function getAsArrayByExtension(array $files): array
{
    $result = [];
    foreach ($files as $file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $content = file_get_contents($file);
        switch ($extension) {
            case 'json':
                $result[] = json_decode($content, true);
                break;
            case 'yml':
                $result[] = (array) Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP);
                break;
        }
    }

    return array_values($result);
}
