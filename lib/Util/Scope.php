<?php

namespace DNAPayments\Util;

class Scope {
    private static $INTEGRATION_HOSTED = 'integration_hosted';
    private static $INTEGRATION_EMBEDDED = 'integration_embedded';
    private static $INTEGRATION_SEAMLESS = 'integration_seamless';
    public static function getScopes($config) {
        $scopes = ['payment'];
        if (property_exists($config, 'allowHosted')) {
            $scopes.push(self::$INTEGRATION_HOSTED);
        }
        if (property_exists($config, 'allowEmbedded')){
            $scopes.push(self::$INTEGRATION_EMBEDDED);
        }
        if (property_exists($config, 'allowSeamless')) {
            $scopes.push(self::$INTEGRATION_SEAMLESS);
        }
        return implode(' ', $scopes);
    }
}