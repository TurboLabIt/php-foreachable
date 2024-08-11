<?php
namespace TurboLabIt\Foreachable;


abstract class ForeachableCollection implements \Iterator, \Countable, \ArrayAccess
{
    use Foreachable;
}
