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

    public function first()
    {
        if( $this->arrData == [] ) {
            return null;
        }

        $firstKey = array_keys($this->arrData)[0];
        return $this->arrData[$firstKey];
    }


    public function popFirst()
    {
        if( $this->arrData == [] ) {
            return null;
        }

        $firstKey   = array_keys($this->arrData)[0];
        $firstValue = $this->arrData[$firstKey];
        unset($this->arrData[$firstKey]);
        return $firstValue;
    }


    public function last()
    {
        if( $this->arrData == [] ) {
            return null;
        }

        $lastKey = array_reverse(array_keys($this->arrData))[0];
        return $this->arrData[$lastKey];
    }


    public function get($key)
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


    public function getItems(int $numOfItems, $offset = 0, bool $allOrNothing = false, bool $applyToSource = true) : array
    {
        if( $numOfItems <= 0 || $offset >= count($this->arrData) ) {
            return [];
        }

        $arrExtractedItems = [];
        $i=0;
        foreach($this->arrData as $k => $value) {

            if( $i < $offset ) {

                $i++;
                continue;
            }
            $i++;

            $arrExtractedItems[$k] = $value;

            if( count($arrExtractedItems) == $numOfItems ) {
                break;
            }
        }

        if( $allOrNothing && count($arrExtractedItems) < $numOfItems ) {
            return [];
        }

        if($applyToSource) {
            foreach( array_keys($arrExtractedItems) as $key) {
                unset( $this->arrData[$key] );
            }
        }

        return $arrExtractedItems;
    }


    protected function getRealForeachablePosition()
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
        if( empty($this->arrData) ) {
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


    public function filterIfNotEmptyResult(callable $callback, $reindexToNumericArray = false) : self
    {
        $arrDataFiltered = $this->getFilteredData($callback, $reindexToNumericArray);
        if( !empty($arrDataFiltered) ) {
            $this->arrData = $arrDataFiltered;
        }

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


    public function next() : void
    {
        ++$this->position;
    }


    public function rewind() : void
    {
        $this->position = 0;
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

    public function offsetExists($offset) : bool
    {
        $arrValue = array_values($this->arrData);
        return isset($arrValue[$offset]);
    }

    public function offsetGet($offset) : mixed
    {
        $arrValue = array_values($this->arrData);
        return isset($arrValue[$offset]) ? $arrValue[$offset] : null;
    }

    public function offsetSet($offset, $value) : void
    {
        if ( is_null($offset) ) {

            $this->arrData[] = $value;
            return;
        }

        $arrKeys = array_values(array_flip($this->arrData));
        if( !array_key_exists($offset, $arrKeys) ) {

            $this->arrData[$offset] = $value;
            return;
        }

        $realKey = $arrKeys[$offset];
        $this->arrData[$realKey] = $value;
    }

    public function offsetUnset($offset) : void
    {
        $arrKeys = array_values(array_flip($this->arrData));
        if( !array_key_exists($offset, $arrKeys) ) {
            return;
        }

        $realKey = $arrKeys[$offset];
        unset($this->arrData[$realKey]);
    }
}
