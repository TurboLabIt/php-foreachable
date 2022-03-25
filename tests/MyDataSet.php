<?php
namespace TurboLabIt\Foreachable\tests;

use TurboLabIt\Foreachable\Foreachable;


class MyDataSet implements \Iterator, \Countable, \ArrayAccess
{
    use Foreachable;

    public function __construct()
    {
        $this->arrData = [
            "spider-man"=> (object)[
                "name"      => "peter",
                "surname"   => "parker"
            ],
            "batman"    => (object)[
                "name"      => "bruce",
                "surname"   => "wayne"
            ]
        ];
    }
}
