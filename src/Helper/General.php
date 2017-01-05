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
    
    /**
     * Function for extract data parameter data from the URL.
     * This function is most valuable in "AJAX" calls.
     * 
     * @param string $field Field to Extract
     * @return string extracted data
     */
    public static function extractDataFromHTTP($field)
    {
        $result = '';
        $source = $_SERVER['HTTP_REFERER'];
        $source = explode('?', $source);
        $source = explode('&', $source[1]);
        foreach ($source as $key => $value) {
            if (str_contains($value, $field)) {
                $result = str_replace($field . '=', '', $value);
            }
        }
        return $result;
    }
    
    /** 
     * To Check the given content is Exist in Array or Not
     */
     public static function checkExist($source, $data)
    {
        return array_search($data, $source);
    }    
    
    /**
     * Eliminate all un-necessary contents in string.
     * @param $string
     */
    public static function makeString(&$string)
    {
        $string = strtolower($string);
        $string = str_replace(" | ", "-", $string);
        $string = str_replace(" ", "-", $string);
        $string = preg_replace('/[^a-zA-Z0-9\']/', '-', $string);
        $string = str_replace("'", '', $string);
    }
    
    /**
     * To Check Mail with multiple possibilities.
     *
     * @param $email
     * @return bool
     */
    public static function checkMail($email)
    {
        // Simple Field Validation.
        if (!$email) return false;

        // Simple String Validation
        $email = strval($email);
        if (!$email) return false;

        // Check received data with Email Syntax validation.
        if (!filter_var($email, FILTER_SANITIZE_EMAIL)) return false;

        return true;
    }
    
    public static function getOS($user_agent) { 

    $os_platform    =   "Unknown OS Platform";
        
    if(!($user_agent = strval($user_agent))) return $os_platform;

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

    
/**
 * To Unset Array with List of Keys.
 */
public static function unsetArray($key, &$array)
{
        if (isset($key)) {
            if (is_array($key)) {
                foreach ($key as $index) {
                    if (isset($array[$index])) unset($array[$index]);
                }
            } else {
                unset($array[$key]);
            }
        }

        return $array;
}
    
/**
 * To Get Active Broswer
 */
public static function getBrowser() 
  {    
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser        =   "Unknown Browser";
    
    if(!($user_agent = strval($user_agent))) return $browser;

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

  }
}
