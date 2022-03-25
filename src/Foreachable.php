<?php
/**
 * @see https://github.com/TurboLabIt/php-foreachable/
 */
namespace TurboLabIt\Foreachable;

trait Foreachable
{
    protected array $arrData = [];
    protected int $position = 0;


    /**
     * Foreachable specials
     * ====================
     */

    public function first() : ?mixed
    {
        if( $this->arrData == [] ) {
            return null;
        }

        $firstKey = array_keys($this->arrData)[0];
        return $this->arrData[$firstKey];
    }


    public function last() : ?mixed
    {
        if( $this->arrData == [] ) {
            return null;
        }

        $lastKey = array_reverse(array_keys($this->arrData))[0];
        return $this->arrData[$lastKey];
    }


    public function get($key) : ?mixed
    {
        if( !array_key_exists($key, $this->arrData) ) {
            return null;
        }

        return $this->arrData[$key];
    }


    public function clear() : self
    {
        $this->arrData = [];
        $this->rewind();
        return $this;
    }


    public function getAll() : array
    {
        return $this->arrData;
    }


    public function slice($num, $offset = 0, bool $applyToSource = false) : array
    {
        $arrSliced = array_slice($this->arrData, $offset, $num, true);

        if($applyToSource) {
            $this->arrData = $arrSliced;
        }

        return $arrSliced;
    }


    protected function getRealForeachablePosition() : mixed
    {
        $keys = array_keys($this->arrData);
        if( !array_key_exists($this->position, $keys) ) {
            return false;
        }

        return $keys[$this->position];
    }


    public function iterate(callable $callback) : self
    {
        if(empty($this->arrData)) {
            return [];
        }

        array_walk($this->arrData, $callback);

        return $this;
    }


    public function getFilteredData(callable $callback, $reindexToNumericArray = false) : array
    {
        if(empty($this->arrData)) {
            return [];
        }

        $arrData = array_filter($this->arrData, $callback);

        if($reindexToNumericArray) {
            $arrData = array_values($arrData);
        }

        return $arrData;
    }


    public function filter(callable $callback, $reindexToNumericArray = false) : self
    {
        $this->arrData = $this->getFilteredData($callback, $reindexToNumericArray);
        return $this;
    }


    /**
     * The Iterator interface
     * ======================
     * @see https://www.php.net/manual/en/class.iterator.php
     */

    public function current() : mixed
    {
        $key = $this->getRealForeachablePosition();
        if($key === false) {
            return null;
        }

        return $this->arrData[$key];
    }


    public function key() : mixed
    {
        return $this->position;
    }


    public function next()
    {
        ++$this->position;
        return $this;
    }


    public function rewind()
    {
        $this->position = 0;
        return $this;
    }


    public function valid() : bool
    {
        $key = $this->getRealForeachablePosition();
        return $key !== false;
    }


    /**
     * The Countable interface
     * =======================
     * @see https://www.php.net/manual/en/class.countable.php
     */

    public function count() : int
    {
        return count($this->arrData);
    }


    /**
     * The ArrayAccess interface
     * =========================
     * @see https://www.php.net/manual/en/class.arrayaccess.php
     */

    public function offsetExists($offset)
    {
        $arrValue = array_values($this->arrData);
        return isset($arrValue[$offset]);
    }

    public function offsetGet($offset)
    {
        $arrValue = array_values($this->arrData);
        return isset($arrValue[$offset]) ? $arrValue[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if ( is_null($offset) ) {

            $this->arrData[] = $value;
            return null;
        }

        $arrKeys = array_values(array_flip($this->arrData));
        if( !array_key_exists($offset, $arrKeys) ) {

            $this->arrData[$offset] = $value;
            return null;
        }

        $realKey = $arrKeys[$offset];
        $this->arrData[$realKey] = $value;
        return null;
    }

    public function offsetUnset($offset)
    {
        $arrKeys = array_values(array_flip($this->arrData));
        if( !array_key_exists($offset, $arrKeys) ) {
            return null;
        }

        $realKey = $arrKeys[$offset];
        unset($this->arrData[$realKey]);
        return null;
    }
}
