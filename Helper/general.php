<?php
namespace shankarbala33\db_explorer\Helper;

/**
 * General - Snippets are used for basic needs of PHP snippets
 */
/**
 * Class General
 * @package Helper
 */
class General{

    /**
     * To Compare the array of items to find any changes are happened.
     *
     * @param array $source1 Set Of Array on Before Changes
     * @param array $source2 Set Of Array on After Changes
     * @param string $search type of search
     * @return bool True No Difference | False Has Difference
     */
    public static function checkArrayDifference($source1, $source2, $search)
    {
        if (count($source1) == 0 and count($source2) == 0) return true;
        if ($search == 'all') {
            loop:
            if (count($source1) == 0) return true;
            if (count($source1) != count($source2)) return false;
            $last_bfr = (array_last($source1));
            $last_aft = (array_last($source2));
            if (!empty(array_diff($last_bfr, $last_aft))) {
                return false;
            } else {
                array_pop($source1);
                array_pop($source2);
                goto loop;
            }
        }
        return true;
    }

    /**
     * To POP the array element with the given 'needle'
     *
     * @param array $data of source
     * @param string $field of the array
     * @param string $needle to check
     */
    public static function eliminateArrayIf(&$data, $field, $needle)
    {
        foreach ($data as $key => $value) {
            if ($value[$field] == $needle) unset($data[$key]);
        }
    }

    /**
     * To Convert nested array to Objects
     *
     * @param array $array Raw Array
     * @return array Raw Object
     */
    public static function arrayToObject(&$array)
    {
        if (is_array($array) OR is_object($array)) {
            if (is_array($array)) {
                if (count($array) <= 0) return array();

                /** Single Stage Object Convert */
                foreach ($array as $key => $value) {
                    $array[$key] = (object)$value;
                }
            }
        }
    }

    /**
     * To Extract Array item's of given indexes
     *
     * @param array $indexes list of indexes
     * @param array $source source Array
     * @return array Extracted Array of Given index
     */
    public static function extractArray($indexes, $source)
    {
        $result = array();
        if (is_array($source)) {
            $hash = 0;
            foreach ($source as $key => $value) {
                foreach ($indexes as $id => $index) {
                    if (in_array($index, $value)) {
                        $result[$hash][$index] = $value[$indexes[$id]];
                    }
                }
                $hash = $hash + 1;
            }
        }
        return $result;
    }
}