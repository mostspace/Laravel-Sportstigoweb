<?php

namespace SenangPay;

class SenangPay
{
    /**
     * senangPay Url.
     *
     * @var string
     */
    private $senangPayUrl;

    /**
     * senangPay Merchant ID.
     *
     * @var string
     */
    private $merchantId;

    /**
     * senangPay Secret Key.
     *
     * @var stringa
     */
    private $secretKey;

    /**
     * Construct a new senangPay instance
     *
     * @param string $merchantId
     * @param string $secretKey
     * @param string|null $senangPayUrl
     *
     * @return string
     **/
    public function __construct($merchantId, $secretKey, $senangPayUrl = null)
    {
        $this->senangPayUrl = $senangPayUrl ? $senangPayUrl : 'https://app.senangpay.my';
        $this->secretKey = $secretKey;
        $this->merchantId = $merchantId;
    }

    /**
     * Get Merchant Id
     *
     * @return string|null
     **/
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * Generate senangPay Payment URL
     *
     * @param Object $params Parameters for senangPay Payment URL
     *
     * @return string
     **/
    public function createPayment($detail, $amount, $orderId, $optionals)
    {
        // Construct params
        $params = [
            'detail' => $detail,
            'amount' => $amount,
            'order_id' => $orderId,
            'hash' => $this->createHash($detail, $amount, $orderId)
        ];

        // Merge optional params with required params
        $params = $optionals ? array_merge($params, $optionals) : $params;

        // Create senangPay payment URL
        $url = $this->senangPayUrl.'/payment/'.$this->merchantId.'?'.http_build_query($params);
        
        return $url;
    }

    /**
     * Create Hash for senangPay Payment URL
     *
     * @param string $detail
     * @param float $amount
     * @param string $orderId
     *
     * @return string|null
     **/
    public function createHash($detail, $amount, $orderId)
    {
        // Construct string from data
        $stringData = $this->secretKey.$detail.$amount.$orderId;

        // generate md5 hash for stringData
        $hashString = md5($stringData);

        return $hashString;
    }

    /**
     * callback function for callback url
     *
     * @param Type $var Description
     * @return bool
     **/
    public function callback(array $data = [])
    {
        $statusId = urldecode($data['status_id']);
        $orderId = urldecode($data['order_id']);
        $msg = urldecode($data['msg']);
        $transactionId = urldecode($data['transaction_id']);
        $hash = urldecode($data['hash']);

        $hashString = md5($this->secretKey.$statusId.$orderId.$transactionId.$msg);

        if ($hashString == $hash) {
            unset($data['hash']);
            return $data;
        } else {
            return [];
        }
    }
}
