<?php

namespace App\Enum;

/**
 * Class UserTypeEnum
 * @package App\Enum
 */
class UserTypeEnum
{
    const Administrator = 'ROLE_ADMIN';
    const User = 'ROLE_USER';

    /**
     * @var array
     */
    public static $labels = [
        self::Administrator => 'Administrator',
        self::User => 'User'
    ];
}
