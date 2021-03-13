<?php
namespace Differ\ParserTests;

use function Differ\getDiff;
use function Differ\getFilesAsSortArray;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testGenDiff()
    {
        $expected = include __DIR__ . '/fixtures/expected.php';
        $firstFile = __DIR__ . '/fixtures/data/file1.json';
        $secondFile = __DIR__ . '/fixtures/data/file2.json';
        list($firstAsArray, $secondAsArray) = getFilesAsSortArray($firstFile, $secondFile);
        $actual = getDiff($firstAsArray, $secondAsArray);

        $this->assertEquals($expected[0], $actual);
    }
}
