<?php

namespace CodeLands\SmsNotification\Observer;

use CodeLands\SmsNotification\Model\Config\ConfigProvider;
use CodeLands\SmsNotification\Model\GatewayFactory;
use CodeLands\SmsNotification\Model\Sms\SmsMessageInterfaceFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlInterface;

class SendSmsPlaceOrder implements ObserverInterface
{
    protected $configProvider;

    protected $smsGateWayFactory;

    protected $smsMessageInterfaceFactory;

    protected $collectionFactory;

    protected $urlBuilder;

    protected $customerRepository;

    public function __construct(
        ConfigProvider $configProvider,
        GatewayFactory $gatewayFactory,
        SmsMessageInterfaceFactory $smsMessageInterfaceFactory,
        UrlInterface $urlBuilder,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->configProvider = $configProvider;
        $this->smsGateWayFactory = $gatewayFactory;
        $this->smsMessageInterfaceFactory = $smsMessageInterfaceFactory;
        $this->urlBuilder = $urlBuilder;
        $this->customerRepository = $customerRepository;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getData('order');
        try {
            if (! $order || ! $order->getId()) {
                return;
            }
            $telephone = $order->getBillingAddress()->getTelephone();
            $orderUrl = $this->urlBuilder->getUrl('sales/order/view/', ['order_id' => $order->getId()]);
            $template = $this->configProvider->getTemplateOrderSuccess();
            $template = str_replace('{{order_url}}', $orderUrl, $template);

            $messageData['data'] = [
                'to' => $telephone,
                'store' => $order->getStoreId(),
                'raw_template' => $template
            ];

            $message = $this->smsMessageInterfaceFactory->create($messageData);
            $this->smsGateWayFactory->create(['message' => $message])->sendMessage();
        } catch (\Exception $e) {
        }
    }
}
