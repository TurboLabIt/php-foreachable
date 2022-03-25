<?php
namespace TurboLabIt\Foreachable\tests;

use PHPUnit\Framework\TestCase;


class ForeachableTest extends TestCase
{
    public function testCurrentNext(): void
    {
        $myDataSet = new MyDataSet();

        $spiderMan = $myDataSet->current();
        $this->assertEquals("peter", $spiderMan->name);
        $this->assertEquals("parker", $spiderMan->surname);

        $myDataSet->next();

        $batman = $myDataSet->current();
        $this->assertEquals("bruce", $batman->name);
        $this->assertEquals("wayne", $batman->surname);

        $myDataSet->next();

        $null = $myDataSet->current();
        $this->assertNull($null);

        $myDataSet->rewind();

        $spiderMan = $myDataSet->current();
        $this->assertEquals("peter", $spiderMan->name);
        $this->assertEquals("parker", $spiderMan->surname);
    }


    public function testFirst(): void
    {
        $myDataSet = new MyDataSet();

        $spiderMan = $myDataSet->first();
        $this->assertEquals("peter", $spiderMan->name);
        $this->assertEquals("parker", $spiderMan->surname);
    }


    public function testLast(): void
    {
        $myDataSet = new MyDataSet();

        $batman = $myDataSet->last();
        $this->assertEquals("bruce", $batman->name);
        $this->assertEquals("wayne", $batman->surname);
    }
}
