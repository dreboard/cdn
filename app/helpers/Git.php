<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 3/16/2018
 * Time: 1:03 AM
 */

namespace App\Main;


class Git
{
    const MAJOR = 1;
    const MINOR = 2;
    const PATCH = 3;

    public static function get()
    {
        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('UTC'));

        return sprintf('v%s.%s.%s-dev (%s)', self::MAJOR, self::MINOR, self::PATCH, $commitDate->format('Y-m-d H:m:s'));
    }
}