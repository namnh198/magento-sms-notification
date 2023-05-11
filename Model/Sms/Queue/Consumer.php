<?php

namespace CodeLands\SmsNotification\Model\Sms\Queue;

use CodeLands\SmsNotification\Model\Sms\SmsMessageException;
use CodeLands\SmsNotification\Model\Sms\SmsMessageInterface;

class Consumer
{
    protected $gatewayFactory;

    public function __construct(
        \CodeLands\SmsNotification\Model\GatewayFactory $gatewayFactory
    ) {
        $this->gatewayFactory = $gatewayFactory;
    }

    public function process(SmsMessageInterface $smsMessage)
    {
        $gateway = $this->gatewayFactory->create(['message' => $smsMessage]);
        try {
            $gateway->sendMessage(true);
        } catch (SmsMessageException $e) {}
    }
}
