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
            ["{$path}/flatFirst.json", "{$path}/flatSecond.json", $expected[0]],
            ["{$path}/flatFirst.yml", "{$path}/flatSecond.yml", $expected[0]],
            // ["{$path}/nestedFirst.json", "{$path}/nestedSecond.json", $expected[1]],
        ];
    }
}
