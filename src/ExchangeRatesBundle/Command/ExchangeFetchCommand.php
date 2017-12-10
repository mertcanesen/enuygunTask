<?php

namespace ExchangeRatesBundle\Command;

use ExchangeRatesBundle\Entity\Currency;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExchangeFetchCommand extends ContainerAwareCommand
{
    protected $lastRates;

    public function __construct()
    {
        parent::__construct();
        $this->lastRates = [
            'USD' => 0,
            'EUR' => 0,
        ];
    }

    protected function configure()
    {
        $this
            ->setName('exchange:fetch')
            ->setDescription('...');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $providers = [
            $this->getContainer()->get('exchange_rates.services_providers.tcmbprovider'),
            $this->getContainer()->get('exchange_rates.services_providers.fccprovider'),
        ];

        foreach ($providers as $provider) {
            $currencyItems = $provider->request();

            foreach ($currencyItems as $currencyKey => $currencyItem) {
                if ($this->lastRates[$currencyKey] == 0 || $currencyItem < $this->lastRates[$currencyKey]) {
                    $this->lastRates[$currencyKey] = $currencyItem;
                }
            }
        }

        $currency = new Currency();
        $currency->setEur($this->lastRates['EUR']);
        $currency->setUsd($this->lastRates['USD']);
        $currency->setCreatedAt(time());

        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $em->persist($currency);
        $em->flush();
    }

}
