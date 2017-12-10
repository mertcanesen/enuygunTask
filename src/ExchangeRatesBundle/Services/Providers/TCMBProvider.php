<?php
/**
 * User: Mert Can ESEN
 * Date: 10.12.2017
 * Time: 03:18
 */

namespace ExchangeRatesBundle\Services\Providers;

use GuzzleHttp\Client;

class TCMBProvider implements ProviderInterface
{
    const ENDPOINT = 'http://www.tcmb.gov.tr/kurlar/today.xml';

    private $client;

    /**
     * TCMBProvider constructor.
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function request()
    {
        $response = $this->client->request('GET', self::ENDPOINT);

        return $this->parseResponse($response->getBody()->getContents());
    }

    /**
     * @param string $data
     * @return array
     */
    public function parseResponse($data)
    {
        $responseObject = simplexml_load_string($data);
        $currencyObjects = $responseObject->Currency;

        $currencyArray = [
            'USD' => 0,
            'EUR' => 0,
        ];

        foreach ($currencyObjects as $currencyObject) {
            if ($currencyObject['CurrencyCode'] == 'USD') {
                $currencyArray['USD'] = (float)$currencyObject->ForexBuying;
            } elseif ($currencyObject['CurrencyCode'] == 'EUR') {
                $currencyArray['EUR'] = (float)$currencyObject->ForexBuying;
            }
        }

        return $currencyArray;
    }
}