<?php

namespace Omnipay\PayULatam\Messages;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Exception\InvalidRequestException;

class Notification implements NotificationInterface
{
    /**
     * The request client.
     *
     * @var \Omnipay\Common\Http\ClientInterface
     */
    protected $httpClient;

    /**
     * The HTTP request object.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $httpRequest;

    /**
     * Constructor.
     *
     * @param \Omnipay\Common\Http\ClientInterface      $httpRequest
     * @param \Symfony\Component\HttpFoundation\Request $httpClient
     */
    public function __construct($httpRequest, $httpClient)
    {
        $this->httpRequest = $httpRequest;
        $this->httpClient  = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        if (isset($this->getData()['response_message_pol'])) {
            return $this->getData()['response_message_pol'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->httpRequest->request->all();
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionReference()
    {
        if (isset($this->getData()['transaction_id'])) {
            return (string) $this->getData()['transaction_id'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionStatus()
    {
        if ($this->getData()) {
            $status = (int) $this->getData()['state_pol'];

            if (4 === $status) {
                return NotificationInterface::STATUS_COMPLETED;
            }

            if (6 === $status || 5 === $status) {
                return NotificationInterface::STATUS_FAILED;
            }

            throw new InvalidRequestException('We have received unknown status "' . $status . '"');
        }

        return null;
    }
}
