<?php

namespace Differ\Differ;

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
                $result[] = Yaml::parse($content);
                break;
            case 'yaml':
                $result[] = Yaml::parse($content);
                break;
            default:
                throw new \Exception("Format '$extension' is unknown for parsing");
        }
    }

    return array_values($result);
}
