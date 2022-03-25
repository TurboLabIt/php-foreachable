<?php
namespace TurboLabIt\Foreachable\tests;

use TurboLabIt\Foreachable\Foreachable;
use TurboLabIt\TLIBaseBundle\tests\Traits\Data;


class CollectionDummy implements \Iterator, \Countable, \ArrayAccess
{
    // the actual component being tested
    use Foreachable;

    // dummy data
    use DummyData;


    public function __construct()
    {
        for($i=0; $i < 3; $i++) {

            $dummyTitle     = $this->arrDummyData[$i]["title"];
            $dummyAbstract  = $this->arrDummyData[$i]["abstract"];

            $this->arrData[] =
                (new Dummy())
                    ->setTitle($dummyTitle)
                    ->setAbstract($dummyAbstract);
        }
    }
}
