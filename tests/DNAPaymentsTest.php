<?php

use PHPUnit\Framework\TestCase;
use DNAPayments\DNAPayments;

class DNAPaymentsTest extends TestCase
{
    public $currency = 'GBP';
    public $terminal = '___ENTER_TEST_TERMINAL___';
    public $client_id = '___ENTER_TEST_CLIENT_ID___';
    public $client_secret = '___ENTER_TEST_CLIENT_SECRET___';
    public $config = [
        'isTestMode' => true,
        'scopes' => [
            'allowHosted' => true,
            'allowEmbedded' => true
        ]
    ];

    public function testAuthData() {
        try {
            \DNAPayments\DNAPayments::configure($this->config);
            $auth = \DNAPayments\DNAPayments::auth(array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'terminal' => $this->terminal,
                'invoiceId' => date('d-m-y h:i:s'),
                'amount' => 0.01,
                'currency' => $this->currency
            ));

            print_r($auth);
            $this->assertTrue(true);
        } catch (Error $e) {
            echo $e;
            $this->assertTrue(false);
        }
    }
}

