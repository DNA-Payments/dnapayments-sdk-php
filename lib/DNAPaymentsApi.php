<?php

namespace DNAPaymentsApi;

use DNAPaymentsApi\Util\Scope;
use DNAPaymentsApi\Util\HTTPRequester;
use DNAPaymentsApi\Util\LZCompressor\LZString;

class DNAPaymentsApi {

    private static $config = [
        'isTestMode' => false,
        'scopes' => []
    ];
    private static $fiels = [
        'authUrl' => 'https://oauth.dnapayments.com/oauth2/token',
        'testAuthUrl' => 'https://test-oauth.dnapayments.com/oauth2/token',
        'testPaymentPageUrl' => 'https://test-pay.dnapayments.com/checkout',
        'paymentPageUrl' => 'https://pay.dnapayments.com/checkout'
    ];


    private static function getPath()
    {
        if (self::$config['isTestMode']) {
            return (object) [
                'authUrl' => self::$fiels['testAuthUrl'],
                'paymentPageUrl' => self::$fiels['testPaymentPageUrl'],
            ];
        }
        return (object) [
            'authUrl' => self::$fiels['authUrl'],
            'paymentPageUrl' => self::$fiels['paymentPageUrl']
        ];
    }

    private static function encodeToUrl($data)
    {
        return base64_encode(LZString::compressToEncodedURIComponent(json_encode($data)));
    }

    public static function auth($data)
    {
        $authData = [
            'grant_type' => 'client_credentials',
            'scope' => Scope::getScopes(self::$config['scopes']),
            'client_id' => $data->client_id,
            'client_secret' => $data->client_secret,
            'terminal' => $data->terminal,
            'invoiceId' => strval($data->invoiceId),
            'amount' => floatval($data->amount),
            'currency' => strval($data->currency),
            'paymentFormURL' => ''
        ];

        $response = HTTPRequester::HTTPPost(self::getPath()->authUrl, [], $authData);
        if ($response != null && $response['status'] >= 200 && $response['status'] < 400) {
            return $response['response'];
        }

        throw new \Error('Error: No auth service');
    }

    public static function generateUrl($order, $authToken, $terminal)
    {
        return self::getPath()->paymentPageUrl . '/?params=' . self::encodeToUrl((object) [
                'auth' => $authToken,
                'invoiceId' => strval($order->invoiceId),
                'terminal' => $terminal,
                'amount' => floatval($order->amount),
                'currency' => strval($order->currency),
                'postLink' => strval($order->postLink),
                'failurePostLink' => strval($order->failurePostLink),
                'backLink' => strval($order->backLink),
                'failureBackLink' => strval($order->failureBackLink),
                'language' => !empty($order->language) ? strval($order->language) : 'eng',
                'description' => strval($order->description),
                'accountId' => $order->accountId,
                'accountCountry' => $order->accountCountry,
                'accountCity' => $order->accountCity,
                'accountStreet1' => $order->accountStreet1,
                'accountEmail' => $order->accountEmail,
                'accountFirstName' => $order->accountFirstName,
                'accountLastName' => $order->accountLastName,
                'accountPostalCode' => $order->accountPostalCode
            ]) . '&data=' . self::encodeToUrl((object) [
                'isTest' => self::$config['isTestMode']
            ]);
    }

    public static function isValidSignature($result, $secret)
    {
        $string = $result->id . $result->amount . $result->currency . $result->invoiceId . $result->errorCode . json_encode($result->success);
        return base64_encode(hash_hmac('sha256', $string, $secret, true)) == $result->signature;
    }
}