<?php

namespace App\Enum;

/**
 * Class AdvertisementTypeEnum
 * @package App\Enum
 */
class AdvertisementTypeEnum
{
    const Basic = 'BASIC';
    const Video = 'VIDEO';

    /**
     * @var array
     */
    public static $labels = [
        self::Basic => 'Basic',
        self::Video => 'Video'
    ];
}
