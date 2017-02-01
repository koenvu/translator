<?php

namespace Tests\Unit;

use PHPUnit_Framework_TestCase;
use Koenvu\Translator\Comparator;

class ComparatorTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    function it_detects_obsolete_lines()
    {
        $inDatabase = [
            'some-key' => 'Some translation',
            'other-key' => 'Other translation',
            'unused' => 'Obsolete language line',
        ];

        $inFiles = [
            'some-key' => 'Some translation',
            'other-key' => 'Updated translation',
        ];

        $comparator = new Comparator($inDatabase, $inFiles);

        $obsolete = $comparator->obsolete();

        $this->assertArrayHasKey('unused', $obsolete);
        $this->assertArrayNotHasKey('other-key', $obsolete);
    }

    /** @test */
    function it_detects_updated_lines()
    {
        $inDatabase = [
            'some-key' => 'Some translation',
            'other-key' => 'Other translation',
            'unused' => 'Obsolete language line',
        ];

        $inFiles = [
            'some-key' => 'Some translation',
            'other-key' => 'Updated translation',
            'new-key' => 'Some new key',
        ];

        $comparator = new Comparator($inDatabase, $inFiles);

        $obsolete = $comparator->updated();

        $this->assertArrayHasKey('other-key', $obsolete);
        $this->assertArrayNotHasKey('unused', $obsolete);
        $this->assertArrayNotHasKey('new-key', $obsolete);
    }

    /** @test */
    function it_detects_added_lines()
    {
        $inDatabase = [
            'some-key' => 'Some translation',
            'other-key' => 'Other translation',
            'unused' => 'Obsolete language line',
        ];

        $inFiles = [
            'some-key' => 'Some translation',
            'other-key' => 'Updated translation',
            'new-key' => 'This key is new',
        ];

        $comparator = new Comparator($inDatabase, $inFiles);

        $obsolete = $comparator->added();

        $this->assertArrayHasKey('new-key', $obsolete);
        $this->assertArrayNotHasKey('unused', $obsolete);
    }
}
