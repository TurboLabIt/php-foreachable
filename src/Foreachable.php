<?php
/**
 * @see https://github.com/TurboLabIt/php-foreachable/
 */
namespace TurboLabIt\Foreachable;


trait Foreachable
{
    //<editor-fold defaultstate="collapsed" desc="*** 🍹 Class properties ***">
    protected array $arrData    = [];
    protected int $position     = 0;
    //</editor-fold>


    //<editor-fold defaultstate="collapsed" desc="*** 💾 Setters ***">
    public function setData(array $arrData) : static
    {
        $this->arrData = $arrData;
        return $this;
    }


    public function add($item, mixed $key = null, bool $nonPositionalKey = true) : static
    {
        if ($key === null) {

            $this->arrData[] = $item;
            return $this;
        }

        if($nonPositionalKey) {
            $key = (string)$key;
        }

        $this->arrData[$key] = $item;
        return $this;
    }
    //</editor-fold>


    //<editor-fold defaultstate="collapsed" desc="*** 🧹 Removers ***">
    public function clear() : static
    {
        $this->arrData = [];
        $this->rewind();
        return $this;
    }


    public function popFirst() : mixed
    {
        if( $this->arrData == [] ) {
            return null;
        }

        $firstKey   = array_keys($this->arrData)[0];
        $firstValue = $this->arrData[$firstKey];
        unset($this->arrData[$firstKey]);
        return $firstValue;
    }
    //</editor-fold>


    //<editor-fold defaultstate="collapsed" desc="*** 🔎 Getters ***">
    public function get(mixed $key) : mixed
    {
        if( !array_key_exists($key, $this->arrData) ) {
            return null;
        }

        return $this->arrData[$key];
    }


    public function first() : mixed
    {
        if( $this->arrData == [] ) {
            return null;
        }

        $firstKey = array_keys($this->arrData)[0];
        return $this->arrData[$firstKey];
    }


    public function last() : mixed
    {
        if( $this->arrData == [] ) {
            return null;
        }

        $lastKey = array_reverse(array_keys($this->arrData))[0];
        return $this->arrData[$lastKey];
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
    //</editor-fold>


    //<editor-fold defaultstate="collapsed" desc="*** 🔮 Filters ***">
    public function getFilteredData(callable $callback, bool $reindexToNumericArray = false) : array
    {
        $arrData = array_filter($this->arrData, $callback);

        if($reindexToNumericArray) {
            $arrData = array_values($arrData);
        }

        return $arrData;
    }


    public function filter(callable $callback, bool $reindexToNumericArray = false) : static
    {
        $this->arrData = $this->getFilteredData($callback, $reindexToNumericArray);
        return $this;
    }


    public function filterIfNotEmptyResult(callable $callback, bool $reindexToNumericArray = false) : static
    {
        $arrDataFiltered = $this->getFilteredData($callback, $reindexToNumericArray);
        if( !empty($arrDataFiltered) ) {
            $this->arrData = $arrDataFiltered;
        }

        return $this;
    }
    //</editor-fold>


    //<editor-fold defaultstate="collapsed" desc="*** ✴️ Iterate with callback ***">
    public function iterate(callable $callback) : static
    {
        array_walk($this->arrData, $callback);
        return $this;
    }
    //</editor-fold>


    //<editor-fold defaultstate="collapsed" desc="*** 🐘 PHP Iterator interface https://www.php.net/manual/en/class.iterator.php ***">
    protected function getRealForeachablePosition() : mixed
    {
        $keys = array_keys($this->arrData);

        if( !array_key_exists($this->position, $keys) ) {
            return false;
        }

        return $keys[$this->position];
    }


    public function current() : mixed
    {
        $key = $this->getRealForeachablePosition();
        if($key === false) {
            return null;
        }

        return $this->arrData[$key];
    }


    public function key() : mixed { return $this->position; }

    public function next() : void { ++$this->position; }

    public function rewind() : void { $this->position = 0; }


    public function valid() : bool
    {
        $key = $this->getRealForeachablePosition();
        return $key !== false;
    }
    //</editor-fold>


    //<editor-fold defaultstate="collapsed" desc="*** 🐘 PHP Countable interface https://www.php.net/manual/en/class.countable.php ***">
    public function count() : int
    {
        return count($this->arrData);
    }
    //</editor-fold>


    //<editor-fold defaultstate="collapsed" desc="*** 🐘 PHP ArrayAccess interface https://www.php.net/manual/en/class.arrayaccess.php ***">
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
    //</editor-fold>
}
