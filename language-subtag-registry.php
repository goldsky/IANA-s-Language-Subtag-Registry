<?php

/**
 * Language Tags based on Internet Assigned Numbers Authority (IANA)'s Registry.
 *
 * @author  goldsky <goldsky@fastmail.fm>
 * @date    Dec 9, 2016
 *
 * @link    http://www.iana.org/assignments/language-subtag-registry
 */
class LanguageSubtagRegistry
{
    const VERSION = '1.2';

    protected $src;

    public function __construct()
    {
    }

    /**
     * Reading IANA's source by absolute path/URL.
     *
     * @param string $filePath filepath
     *
     * @return bool TRUE | FALSE
     */
    public function readSource($filePath)
    {
        if (!file_exists($filePath)) {
            return false;
        }

        $src = file_get_contents($filePath);
        $this->src = $src;

        return true;
    }

    /**
     * Parse the source string from the file content into a big array.
     *
     * @return array non-associative array
     */
    public function languagesArray()
    {
        $registries = explode('%%', $this->src);
        array_shift($registries); // File-Date: 2010-10-26
        $languagesArray = array();
        foreach ($registries as $regKey => $regVal) {
            $regVal = str_replace("\n  ", ' ', $regVal);
            $rows = explode("\n", $regVal);

            foreach ($rows as $k => $v) {
                if (empty($rows[$k])) {
                    unset($rows[$k]);
                    continue;
                }

                list($key, $val) = explode(':', $v);
                if ($key === 'Description' || $key === 'Prefix') {
                    $languagesArray[$regKey][$key][] = trim($val);
                } else {
                    $languagesArray[$regKey][$key] = trim($val);
                }
            }
        }

        return $languagesArray;
    }

    /**
     * Swap the key of language array by the given key
     * @param   string  $parentKey  parent key
     * @return  array   associative array
     */
    public function languagesAssocArray($parentKey)
    {
        if (empty($parentKey)) {
            return;
        }
        $languagesArray = $this->languagesArray();
        $languagesAssocArray = array();
        foreach ($languagesArray as $row => $info) {
            if (!isset($info[$parentKey]) || empty($info[$parentKey])) {
                continue;
            }
            $languagesAssocArray[$info[$parentKey]] = $languagesArray[$row];
        }

        return $languagesAssocArray;
    }

    /**
     * Direct searching the value of the initial keys.
     *
     * @param array  $assoc     ('key' => 'value') : search the parent key
     *                          with the value
     * @param string $returnKey get the value from this key. If null/ not
     *                          set, it will return the previous value
     *
     * @return string the return value of the given value
     */
    public function languagesAssoc($assoc = array(), $returnKey = null)
    {
        list($assocKey, $assocVal) = each($assoc);
        $languagesAssocArray = $this->languagesAssocArray($assocKey);

        if (empty($returnKey)) {
            return $languagesAssocArray[$assocVal][$assocKey];
        }

        return $languagesAssocArray[$assocVal][$returnKey];
    }
}
