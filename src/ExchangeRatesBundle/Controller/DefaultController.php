<?php

namespace ExchangeRatesBundle\Controller;

use ExchangeRatesBundle\Entity\Currency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $currencyData = $this->getDoctrine()
                             ->getRepository(Currency::class)
                             ->findOneBy([], ['created_at' => 'DESC']);
        $viewParams = [
            'currency' => $currencyData
        ];

        return $this->render('ExchangeRatesBundle:Default:index.html.twig', $viewParams);
    }
}
