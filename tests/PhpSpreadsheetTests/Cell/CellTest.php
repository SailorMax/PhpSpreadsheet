<?php

namespace PhpOffice\PhpSpreadsheetTests\Cell;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Exception;
use PHPUnit_Framework_TestCase;

class CellTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerColumnString
     *
     * @param mixed $expectedResult
     */
    public function testColumnIndexFromString($expectedResult, ...$args)
    {
        $result = Cell::columnIndexFromString(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerColumnString()
    {
        return require 'data/ColumnString.php';
    }

    public function testColumnIndexFromStringTooLong()
    {
        $cellAddress = 'ABCD';

        try {
            Cell::columnIndexFromString($cellAddress);
        } catch (\Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
            self::assertEquals($e->getMessage(), 'Column string index can not be longer than 3 characters');

            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testColumnIndexFromStringTooShort()
    {
        $cellAddress = '';

        try {
            Cell::columnIndexFromString($cellAddress);
        } catch (\Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
            self::assertEquals($e->getMessage(), 'Column string index can not be empty');

            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * @dataProvider providerColumnIndex
     *
     * @param mixed $expectedResult
     */
    public function testStringFromColumnIndex($expectedResult, ...$args)
    {
        $result = Cell::stringFromColumnIndex(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerColumnIndex()
    {
        return require 'data/ColumnIndex.php';
    }

    /**
     * @dataProvider providerCoordinates
     *
     * @param mixed $expectedResult
     */
    public function testCoordinateFromString($expectedResult, ...$args)
    {
        $result = Cell::coordinateFromString(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerCoordinates()
    {
        return require 'data/CellCoordinates.php';
    }

    public function testCoordinateFromStringWithRangeAddress()
    {
        $cellAddress = 'A1:AI2012';

        try {
            Cell::coordinateFromString($cellAddress);
        } catch (\Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
            self::assertEquals($e->getMessage(), 'Cell coordinate string can not be a range of cells');

            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testCoordinateFromStringWithEmptyAddress()
    {
        $cellAddress = '';

        try {
            Cell::coordinateFromString($cellAddress);
        } catch (\Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
            self::assertEquals($e->getMessage(), 'Cell coordinate can not be zero-length string');

            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testCoordinateFromStringWithInvalidAddress()
    {
        $cellAddress = 'AI';

        try {
            Cell::coordinateFromString($cellAddress);
        } catch (\Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
            self::assertEquals($e->getMessage(), 'Invalid cell coordinate ' . $cellAddress);

            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * @dataProvider providerAbsoluteCoordinates
     *
     * @param mixed $expectedResult
     */
    public function testAbsoluteCoordinateFromString($expectedResult, ...$args)
    {
        $result = Cell::absoluteCoordinate(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerAbsoluteCoordinates()
    {
        return require 'data/CellAbsoluteCoordinate.php';
    }

    public function testAbsoluteCoordinateFromStringWithRangeAddress()
    {
        $cellAddress = 'A1:AI2012';

        try {
            Cell::absoluteCoordinate($cellAddress);
        } catch (\Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
            self::assertEquals($e->getMessage(), 'Cell coordinate string can not be a range of cells');

            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * @dataProvider providerAbsoluteReferences
     *
     * @param mixed $expectedResult
     */
    public function testAbsoluteReferenceFromString($expectedResult, ...$args)
    {
        $result = Cell::absoluteReference(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerAbsoluteReferences()
    {
        return require 'data/CellAbsoluteReference.php';
    }

    public function testAbsoluteReferenceFromStringWithRangeAddress()
    {
        $cellAddress = 'A1:AI2012';

        try {
            Cell::absoluteReference($cellAddress);
        } catch (\Exception $e) {
            self::assertInstanceOf(Exception::class, $e);
            self::assertEquals($e->getMessage(), 'Cell coordinate string can not be a range of cells');

            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * @dataProvider providerSplitRange
     *
     * @param mixed $expectedResult
     */
    public function testSplitRange($expectedResult, ...$args)
    {
        $result = Cell::splitRange(...$args);
        foreach ($result as $key => $split) {
            if (!is_array($expectedResult[$key])) {
                self::assertEquals($expectedResult[$key], $split[0]);
            } else {
                self::assertEquals($expectedResult[$key], $split);
            }
        }
    }

    public function providerSplitRange()
    {
        return require 'data/CellSplitRange.php';
    }

    /**
     * @dataProvider providerBuildRange
     *
     * @param mixed $expectedResult
     */
    public function testBuildRange($expectedResult, ...$args)
    {
        $result = Cell::buildRange(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerBuildRange()
    {
        return require 'data/CellBuildRange.php';
    }

    /**
     * @expectedException \TypeError
     */
    public function testBuildRangeInvalid()
    {
        if (PHP_MAJOR_VERSION < 7) {
            $this->markTestSkipped('Cannot catch type hinting error with PHP 5.6');
        }

        $cellRange = '';
        Cell::buildRange($cellRange);
    }

    /**
     * @dataProvider providerRangeBoundaries
     *
     * @param mixed $expectedResult
     */
    public function testRangeBoundaries($expectedResult, ...$args)
    {
        $result = Cell::rangeBoundaries(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerRangeBoundaries()
    {
        return require 'data/CellRangeBoundaries.php';
    }

    /**
     * @dataProvider providerRangeDimension
     *
     * @param mixed $expectedResult
     */
    public function testRangeDimension($expectedResult, ...$args)
    {
        $result = Cell::rangeDimension(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerRangeDimension()
    {
        return require 'data/CellRangeDimension.php';
    }

    /**
     * @dataProvider providerGetRangeBoundaries
     *
     * @param mixed $expectedResult
     */
    public function testGetRangeBoundaries($expectedResult, ...$args)
    {
        $result = Cell::getRangeBoundaries(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerGetRangeBoundaries()
    {
        return require 'data/CellGetRangeBoundaries.php';
    }

    /**
     * @dataProvider providerExtractAllCellReferencesInRange
     *
     * @param mixed $expectedResult
     */
    public function testExtractAllCellReferencesInRange($expectedResult, ...$args)
    {
        $result = Cell::extractAllCellReferencesInRange(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerExtractAllCellReferencesInRange()
    {
        return require 'data/CellExtractAllCellReferencesInRange.php';
    }

    /**
     * @dataProvider providerMergeRangesInCollection
     *
     * @param mixed $expectedResult
     */
    public function testMergeRangesInCollection($expectedResult, ...$args)
    {
        $result = Cell::mergeRangesInCollection(...$args);
        self::assertEquals($expectedResult, $result);
    }

    public function providerMergeRangesInCollection()
    {
        return require 'data/CellMergeRangesInCollection.php';
    }
}
