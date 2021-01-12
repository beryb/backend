<?php
/**
 * Created by PhpStorm.
 * User: ksoldo
 * Date: 19/09/2019
 * Time: 19:37
 */

namespace App\Enum;


/**
 * Class        UserTypeEnum
 *
 * @since       1.0.0
 * @package     App\Enum
 * @author      Kristijan Soldo <soldokristijan@yahoo.com>
 */
class UserTypeEnum
{
    const Developer = 1;
    const Consultant = 2;

    /**
     * @var array
     */
    public static $labels = [
        self::Developer => 'Developer',
        self::Consultant => 'Consultant'
    ];
}