<?php

namespace CodeLands\SmsNotification\Model;

interface GatewayInterface
{
    /**
     * @params $forceSync
     * @return bool
     * @throws \CodeLands\SmsNotification\Model\Sms\SmsMessageException
     */
    public function sendMessage($forceSync = false);

    /**
     * @return \CodeLands\SmsNotification\Model\Sms\SmsMessageInterface
     */
    public function getMessage();
}
