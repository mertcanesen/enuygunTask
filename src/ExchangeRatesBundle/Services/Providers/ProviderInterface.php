<?php
/**
 * Created by PhpStorm.
 * User: Mert Can ESEN
 * Date: 10.12.2017
 * Time: 01:10
 */

namespace ExchangeRatesBundle\Services\Providers;

interface ProviderInterface
{
    /**
     * @return array|null Islem sirasinda hata olusursa null degeri doner.
     */
    public function request();

    /**
     * @param $data
     * @return array
     */
    public function parseResponse($data);

}