<?php
namespace Differ\ParserTests;

use function Differ\gendiff;
use PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    /**
     * @dataProvider additionalProvider
     */
    public function testGetDiff(string $firstFilePath, string $secondFilePath, $expected)
    {
        $actual = gendiff($firstFilePath, $secondFilePath);
        $this->assertEquals($expected, $actual);
    }

    public function additionalProvider()
    {
        $path = __DIR__ . '/fixtures/data';
        $expected = include __DIR__ . '/fixtures/expected.php';
        return [
            ["{$path}/file1.json", "{$path}/file2.json", $expected[0][0]],
            ["{$path}/file1.yml", "{$path}/file2.yml", $expected[0][0]],
        ];
    }
}
