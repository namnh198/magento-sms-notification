<?php

namespace CodeLands\SmsNotification\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    const XPATH_GENERAL_ASYNC = 'general/async_all';
    const XPATH_GENERAL_LOG_SMS = 'general/log_sms';
    const XPATH_GENERAL_DEVELOP = 'general/develop';
    const XPATH_CONFIGURATION_SMS_GATEWAY = 'configuration/gate_way';
    const XPATH_CONFIGURATION_TWILIO_ACCOUNT_SID = 'configuration/twilio_sid';
    const XPATH_CONFIGURATION_TWILIO_AUTH_TOKEN = 'configuration/twilio_token';
    const XPATH_CONFIGURATION_TWILIO_PHONE_NUMBER = 'configuration/twilio_phone_number';
    const XPATH_CONFIGURATION_SMS_TO_SENDER_ID = 'configuration/sms_to_sender_id';
    const XPATH_CONFIGURATION_SMS_TO_API_KEY = 'configuration/sms_to_api_key';

    const XPATH_SMS_TEMPLATE_ORDER_SUCCESS = 'sms_template/order_success';
    const XPATH_SMS_TEMPLATE_VERIFY_ACCOUNT = 'sms_template/verify_account';
    const XPATH_SMS_TEMPLATE_PASSWORD_RESET = 'sms_template/password_reset';
    const XPATH_SMS_TEMPLATE_OTP_LENGTH = 'sms_template/otp_length';

    protected $pathPrefix = 'sms_notification/';

    protected $scopeConfig;

    protected $data = [];

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;

        if ($this->pathPrefix === '/') {
            throw new \LogicException('$pathPrefix should be declared');
        }
    }

    public function isAsync($storeId = null)
    {
        return $this->isSetFlag(self::XPATH_GENERAL_ASYNC, $storeId);
    }

    public function isDevelop($storeId = null)
    {
        return $this->isSetFlag(self::XPATH_GENERAL_DEVELOP, $storeId);
    }

    public function isLogSms($storeId = null)
    {
        return $this->isSetFlag(self::XPATH_GENERAL_LOG_SMS, $storeId);
    }

    public function getSmsGateway($storeId = null)
    {
        return $this->getValue(self::XPATH_CONFIGURATION_SMS_GATEWAY, $storeId);
    }

    public function getTwilioAccountSID($storeId = null)
    {
        return $this->getValue(self::XPATH_CONFIGURATION_TWILIO_ACCOUNT_SID, $storeId);
    }

    public function getTwilioAuthToken($storeId = null)
    {
        return $this->getValue(self::XPATH_CONFIGURATION_TWILIO_AUTH_TOKEN, $storeId);
    }

    public function getTwilioPhoneNumber($storeId = null)
    {
        return $this->getValue(self::XPATH_CONFIGURATION_TWILIO_PHONE_NUMBER, $storeId);
    }

    public function getSmsToSenderId($storeId = null)
    {
        return $this->getValue(self::XPATH_CONFIGURATION_SMS_TO_SENDER_ID, $storeId);
    }

    public function getSmsToApiKey($storeId = null)
    {
        return $this->getValue(self::XPATH_CONFIGURATION_SMS_TO_API_KEY, $storeId);
    }

    public function getTemplateOrderSuccess($storeId = null)
    {
        return $this->getValue(self::XPATH_SMS_TEMPLATE_ORDER_SUCCESS, $storeId);
    }

    public function getTemplateVerifySms($storeId = null)
    {
        return $this->getValue(self::XPATH_SMS_TEMPLATE_VERIFY_ACCOUNT, $storeId);
    }

    public function getTemplateResetPassword($storeId = null)
    {
        return $this->getValue(self::XPATH_SMS_TEMPLATE_PASSWORD_RESET, $storeId);
    }

    public function getOtpLength($storeId = null)
    {
        return $this->getValue(self::XPATH_SMS_TEMPLATE_OTP_LENGTH, $storeId);
    }

    protected function getValue($path, $storeId = null, $scope = ScopeInterface::SCOPE_STORE)
    {
        if ($storeId === null && $scope !== ScopeConfigInterface::SCOPE_TYPE_DEFAULT) {
            return $this->scopeConfig->getValue($this->pathPrefix . $path, $scope, $storeId);
        }

        if ($storeId instanceof \Magento\Framework\App\ScopeInterface) {
            $storeId = $storeId->getId();
        }
        $scopeKey = $storeId . $scope;
        if (!isset($this->data[$path]) || !\array_key_exists($scopeKey, $this->data[$path])) {
            $this->data[$path][$scopeKey] = $this->scopeConfig->getValue($this->pathPrefix . $path, $scope, $storeId);
        }

        return $this->data[$path][$scopeKey];
    }

    protected function isSetFlag($path, $storeId = null, $scope = ScopeInterface::SCOPE_STORE)
    {
        return (bool)$this->getValue($path, $storeId, $scope);
    }
}
