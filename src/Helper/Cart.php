<?php
namespace shankarbala33\db_explorer\Helper;

/**
 * General - Snippets are used for basic needs of PHP snippets
 */
/**
 * Class General
 * @package Helper
 */
class Cart{


    /**
     * To Get complete possible combinations of the given sets of array
     *
     * @param $input array of cart option sets
     * @return array of Complete combinations of given sets
     */
    public static function cartesian($input)
    {
        $result = array();

        while (list($key, $values) = each($input)) {
            if (empty($values)) {
                continue;
            }

            if (empty($result)) {
                foreach ($values as $value) {
                    $result[] = array($key => $value);
                }
            } else {
                $append = array();

                foreach ($result as &$product) {
                    $product[$key] = array_shift($values);

                    $copy = $product;

                    foreach ($values as $item) {
                        $copy[$key] = $item;
                        $append[] = $copy;
                    }

                    array_unshift($values, $product[$key]);
                }

                $result = array_merge($result, $append);
            }
        }

        return $result;
    }

}