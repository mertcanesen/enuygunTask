<?php
/**
 * User: Mert Can ESEN
 * Date: 10.12.2017
 * Time: 03:32
 */

namespace ExchangeRatesBundle\Services\Providers;

use GuzzleHttp\Client;

class FCCProvider implements ProviderInterface
{
    const ENDPOINT = 'https://free.currencyconverterapi.com/api/v5/convert?q=USD_TRY,EUR_TRY&compact=ultra';

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
     * @throws \Exception
     */
    public function request()
    {
        try {
            $response = $this->client->request('GET', self::ENDPOINT);
        } catch (\Exception $exception) {
            throw new \Exception("[FCCProvider] Whoops - something went wrong here.");
        }

        return $this->parseResponse($response->getBody()->getContents());
    }

    /**
     * @param string $data
     * @return array
     */
    public function parseResponse($data)
    {
        $responseObject = json_decode($data);

        $currencyArray = [
            'USD' => $responseObject->USD_TRY,
            'EUR' => $responseObject->EUR_TRY,
        ];

        return $currencyArray;
    }
}