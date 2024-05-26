<?php
namespace DNAPayments\Util;

use GuzzleHttp\Client;

class HTTPRequester
{
    private static $httpClient;

    /**
     * @description Make HTTP-GET call
     * @param       $url
     * @param array $headers
     * @param array $options
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPGet($url, array $headers, array $data = null)
    {
        return self::HTTPRequest('GET', $url, $headers, $data);
    }

    /**
     * @description Make HTTP-POST call
     * @param       $url
     * @param array $headers
     * @param array|string $options
     * @return array HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPPost($url, array $headers, $data)
    {
        return self::HTTPRequest('POST', $url, $headers, $data);
    }

    /**
     * @description Make HTTP-PUT call
     * @param       $url
     * @param array $headers
     * @param array $options
     * @return array HTTP-Response body or an empty string if the request fails or is empty
     * @throws \Exception
     */
    public static function HTTPPut($url, array $headers, array $data = null)
    {
        return self::HTTPRequest('PUT', $url, $headers, $data);
    }

    /**
     * @param    $url
     * @param array $headers
     * @param array $options
     * @return array HTTP-Response body or an empty string if the request fails or is empty
     * @category Make HTTP-DELETE call
     */
    public static function HTTPDelete($url, array $headers, array $data)
    {
        return self::HTTPRequest('DELETE', $url, $headers, $data);
    }

    private static function HTTPRequest($method, $url, array $headers, $data = null)
    {
        $options = [
            'headers' => $headers
        ];
        
        $contentType = isset($headers['Content-Type']) ? $headers['Content-Type'] : '';
        if (isset($data)) {
            if ($contentType === 'application/json') {
                $options['json'] = $data;
            } else {
                $options['form_params'] = $data;
            }
        }

        if (self::$httpClient === null) {
            self::$httpClient = new Client();
        }

        $raw_response = self::$httpClient->request($method, $url, $options);

        return [
            "status" => $raw_response->getStatusCode(),
            "response" => json_decode($raw_response->getBody(), true)
        ];
    }
}
