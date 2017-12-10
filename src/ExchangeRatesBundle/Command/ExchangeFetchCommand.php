<?php

namespace ExchangeRatesBundle\Command;

use ExchangeRatesBundle\Entity\Currency;
use ExchangeRatesBundle\Services\Providers\FCCProvider;
use ExchangeRatesBundle\Services\Providers\TCMBProvider;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $providers = [
            new TCMBProvider(),
            new FCCProvider(),
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
