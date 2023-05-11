<?php

namespace CodeLands\SmsNotification\Model;

use Magento\Framework\Model\AbstractModel;
use CodeLands\SmsNotification\Model\Sms\SmsMessageInterface;

class SmsLog extends AbstractModel
{
    public function _construct()
    {
        $this->_init(ResourceModel\SmsLog::class);
    }

    public function saveLog(SmsMessageInterface $message, $status = true)
    {
        try {
            $this->setData('sms_content', $message->getRawTemplate());
            $this->setData('status', $status);
            $this->setData('store_id', $message->getStore());
            $this->setData('recipient', $message->getTo());
            if ($this->getData('sms_content')) {
                $this->save();
            }
        } catch (\Exception $e) {
            $this->_logger->critical('Send SMS Error: ', ['exception' => $e]);
        }
    }
}
