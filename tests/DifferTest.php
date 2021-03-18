<?php

namespace Differ\ParserTests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider additionalProvider
     */
    public function testGetDiff(string $format, string $firstFilePath, string $secondFilePath, $expected)
    {
        $actual = genDiff($firstFilePath, $secondFilePath, $format);
        $this->assertEquals($expected, $actual);
    }

    public function additionalProvider()
    {
        $path = __DIR__ . '/fixtures/data';
        $expected = include __DIR__ . '/fixtures/expected.php';
        return [
            ["stylish", "{$path}/flatFirst.json", "{$path}/flatSecond.json", $expected[0]],
            ["stylish", "{$path}/flatFirst.yml", "{$path}/flatSecond.yml", $expected[0]],
            ["stylish", "{$path}/flatFirst.json", "{$path}/flatSecond.yml", $expected[0]],
            ["stylish", "{$path}/flatFirst.yml", "{$path}/flatSecond.json", $expected[0]],
            ["stylish", "{$path}/nestedFirst.json", "{$path}/nestedSecond.json", $expected[1]],
            ["plain", "{$path}/nestedFirst.json", "{$path}/nestedSecond.json", $expected[2]],
            ["json", "{$path}/nestedFirst.json", "{$path}/nestedSecond.json", $expected[3]],
        ];
    }
}
