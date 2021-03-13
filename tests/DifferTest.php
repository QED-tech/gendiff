<?php
namespace Differ\ParserTests;

use function Differ\getDiff;
use function Differ\getFilesAsSortArray;
use PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    /**
     * @dataProvider additionalProvider
     */
    public function testGetDiffJson(string $firstFilePath, string $secondFilePath)
    {
        $expected = include __DIR__ . '/fixtures/expected.php';
        [$firstAsArray, $secondAsArray] = getFilesAsSortArray($firstFilePath, $secondFilePath);
        $actual = getDiff($firstAsArray, $secondAsArray);

        $this->assertEquals($expected[0], $actual);
    }

    public function additionalProvider()
    {
        $path = __DIR__ . '/fixtures/data';
        return [
            ["{$path}/file1.json", "{$path}/file2.json"],
            ["{$path}/file1.yml", "{$path}/file2.yml"],
        ];
    }
}
