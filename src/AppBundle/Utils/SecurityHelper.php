<?php
namespace AppBundle\Utils;


class SecurityHelper {


    public function __construct()
    {

    }

    /**
     * @param null $prefix
     * @return string
     */
    public function generateHash($prefix = null) {
        $hash = uniqid(). md5(uniqid(rand(1, 10000), true));
        if ($prefix) {
            $hash = $prefix . '_' .$hash;
        }
        return $hash;
    }


}