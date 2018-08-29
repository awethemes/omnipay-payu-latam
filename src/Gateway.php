<?php

namespace Omnipay\PayULatam;

use Omnipay\Common\AbstractGateway;
use Omnipay\PayULatam\Messages\Notification;

/**
 * @method \Omnipay\Common\Message\ResponseInterface capture(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface refund(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface authorize(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface void(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface createCard(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface updateCard(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface deleteCard(array $options = [])
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'PayU Latam';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'apiKey'     => '',
            'merchantId' => '',
            'accountId'  => '',
            'testMode'   => true,
        ];
    }

    public function setMerchantId($value)
    {
        $this->setParameter('merchantId', $value);
    }

    public function setAccountId($value)
    {
        $this->setParameter('accountId', $value);
    }

    public function setApiKey($value)
    {
        $this->setParameter('apiKey', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(\Omnipay\PayULatam\Messages\PurchaseRequest::class, $parameters);
    }

    /**
     * Create the notification.
     *
     * @return Notification
     */
    public function acceptNotification()
    {
        return new Notification($this->httpRequest, $this->httpClient);
    }
}
