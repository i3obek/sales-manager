<?php

namespace App\Service\ExchangeRate;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ExchangeRateInterface
{
    public function getRates(): ResponseInterface;
    public function index();
    public function store();
    public function update();
    public function remove();
}