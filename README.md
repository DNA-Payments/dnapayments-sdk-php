## Running Tests

To run the tests, use the following command:

```bash
./vendor/bin/phpunit ./tests
```

### Configuration data

```php
[
    'isTestMode' => true,
    'scopes' => [
        'allowHosted' => true,
        'allowEmbedded' => true,
        'allowSeamless' => true
    ],
    'isEnableDonation' => false,
    'autoRedirectDelayInMs' => 20000,
    'paymentTimeoutInSeconds' => 600,
    'allowSavingCards' => true,
    'cards' => [
        [
            'merchantTokenId' => '3UGTOmzrP+Y8onM5wsQCc2eIjeZDpoBKqP3Mem80Re0fMQ==',
            'panStar' => '***************1111',
            'cardSchemeId' => 11,
            'cardSchemeName' => 'VISA',
            'cardName' => 'JOHN DOE',
            'expiryDate' => '05/29',
            'cscState' => 'required', // optional, hidden
            'useStoredBillingData' => false
        ]
    ],
    'disabledCardSchemes' => [
        [
            'cardSchemeId' => 1,
            'cardSchemeName' => 'Amex'
        ]
    ],
    'locale' => [
        'targetLocale' => 'en_GB'
    ]            
];
```

### Payment data

```php
[
    'invoiceId' => $invoice_id,
    'description' => 'Payment description if needed',
    'amount' => $amount,
    'currency' => $this->currency,
    'language' => 'en-gb',
    'paymentSettings' => [
        'terminalId' => $this->terminal,
        'returnUrl' => 'https://test-pay.dnapayments.com/checkout/success.html',
        'failureReturnUrl' => 'https://test-pay.dnapayments.com/checkout/failure.html',
        'callbackUrl' => 'https://pay.dnapayments.com/checkout',
        'failureCallbackUrl' => 'https://testmerchant/order/1123/fail'
    ],
    'customerDetails' => [
        'email' => 'test@dnapayments.com',
        'accountDetails' => [
            'accountId' => 'uuid000001',
        ],
        'billingAddress' => [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'addressLine1' => 'Fulham Rd',
            'postalCode' => 'SW6 1HS',
            'city' => 'London',
            'country' => 'GB'
        ],
        'deliveryDetails' => [
            'deliveryAddress' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'addressLine1' => 'Fulham Rd',
                'addressLine2' => 'Fulham',
                'postalCode' => 'SW6 1HS',
                'city' => 'London',
                'phone' => '0475662834',
                'country' => 'GB'
            ],
        ]
    ],
    'orderLines' => [
        [
            'name' => 'Running shoe',
            'quantity' => 1,
            'unitPrice' => 24,
            'taxRate' => 20,
            'totalAmount' => 24,
            'totalTaxAmount' => 4,
            'imageUrl' => 'https://www.exampleobjects.com/logo.png',
            'productUrl' => 'https://.../AD6654412.html'
        ]
    ]
];
```