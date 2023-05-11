<?php

namespace CodeLands\SmsNotification\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR   = 0;

    public function toOptionArray()
    {
        return [
            ['value' => self::STATUS_SUCCESS, 'label' => __('Success')],
            ['value' => self::STATUS_ERROR, 'label' => __('Error')],
        ];
    }
}