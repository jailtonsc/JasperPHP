<?php

namespace JasperPHP;

/**
 * Class XmlToArray
 * @package JasperPHP
 */
class XmlToArray
{
    /**
     * @param $dataXml
     * @return mixed
     */
    public static function xmlToArray($dataXml)
    {
        return unserialize(serialize(json_decode(json_encode((array)simplexml_load_file($dataXml, null, LIBXML_NOCDATA)), 1)));
    }

}