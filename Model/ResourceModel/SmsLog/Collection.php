<?php

namespace CodeLands\SmsNotification\Model\ResourceModel\SmsLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \CodeLands\SmsNotification\Model\SmsLog::class,
            \CodeLands\SmsNotification\Model\ResourceModel\SmsLog::class
        );
    }

    public function clearLog()
    {
        $this->getConnection()->truncateTable($this->getMainTable());
    }
}
