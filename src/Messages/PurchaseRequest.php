<?php

namespace Omnipay\PayULatam\Messages;

class PurchaseRequest extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->validate(
            'merchantId',
            'accountId',
            'transactionId',
            'currency',
            'buyerEmail',
            'apiKey'
        );

        return [
            'merchantId'      => $this->getParameter('merchantId'),
            'signature'       => $this->generateSignature(),
            'accountId'       => $this->getParameter('accountId'),
            'referenceCode'   => $this->getTransactionId(),
            'description'     => $this->getDescription() ?: $this->getTransactionId(),
            'amount'          => $this->trimZeros($this->getAmount()),
            'tax'             => $this->trimZeros($this->formatCurrency($this->getParameter('tax') ?: 0)),
            'taxReturnBase'   => $this->trimZeros($this->formatCurrency($this->getParameter('taxBase') ?: 0)),
            'buyerEmail'      => $this->getParameter('buyerEmail'),
            'test'            => $this->getTestMode() ? 1 : 0,
            'responseUrl'     => $this->getReturnUrl(),
            'confirmationUrl' => $this->getNotifyUrl(),
            'currency'        => $this->getCurrency(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function setApiKey($apiKey)
    {
        $this->parameters->set('apiKey', $apiKey);
    }

    public function setMerchantId($merchantId)
    {
        $this->parameters->set('merchantId', $merchantId);
    }

    public function setAccountId($accountId)
    {
        $this->parameters->set('accountId', $accountId);
    }

    public function setSiteName($siteName)
    {
        $this->parameters->set('siteName', $siteName);
    }

    public function setBuyerEmail($buyerEmail)
    {
        $this->parameters->set('buyerEmail', $buyerEmail);
    }

    protected function generateSignature()
    {
        $args = [
            $this->getParameter('apiKey'),
            $this->getParameter('merchantId'),
            $this->getTransactionId(),
            $this->trimZeros($this->getAmount()),
            $this->getCurrency(),
        ];

        return strtolower(md5(implode('~', $args)));
    }
}
