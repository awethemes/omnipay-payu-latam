<?php

namespace Omnipay\PayULatam\Messages;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /* Constansts */
    const LIVE_ENDPOINT = 'https://gateway.payulatam.com/ppp-web-gateway/';
    const TEST_ENDPOINT = 'https://sandbox.gateway.payulatam.com/ppp-web-gateway/';

    /**
     * Gets the endpoint,
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode() ? static::TEST_ENDPOINT : static::LIVE_ENDPOINT;
    }
}
