<?php

namespace DNAPayments\Util;

class Scope {
    private static $INTEGRATION_HOSTED = 'integration_hosted';
    private static $INTEGRATION_EMBEDDED = 'integration_embedded';
    private static $INTEGRATION_SEAMLESS = 'integration_seamless';
    public static function getScopes($config) {
        $scopes = ['payment'];
        if (array_key_exists('allowHosted', $config)) {
            $scopes.push(self::$INTEGRATION_HOSTED);
        }
        if (array_key_exists('allowEmbedded', $config)){
            $scopes.push(self::$INTEGRATION_EMBEDDED);
        }
        if (array_key_exists('allowSeamless', $config)) {
            $scopes.push(self::$INTEGRATION_SEAMLESS);
        }
        return implode(' ', $scopes);
    }
}