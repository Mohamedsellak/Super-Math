<?php

// Quick test script to verify MercadoPago credentials
require_once 'vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

// Use your exact credentials
MercadoPagoConfig::setAccessToken('TEST-7718145674287696-072014-a29a4213b96189f6d0e6d6881f133c91-166857479');
MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

$client = new PreferenceClient();

$preference = [
    'items' => [
        [
            'title' => 'Test Credit Card Payment',
            'description' => 'Testing different card scenarios',
            'quantity' => 1,
            'unit_price' => 10.0, // Higher amount for testing
            'currency_id' => 'ARS',
        ]
    ],
    'payer' => [
        'email' => 'test@example.com',
    ],
    'external_reference' => 'test_' . time(),
];

try {
    $result = $client->create($preference);
    echo "✅ SUCCESS: MercadoPago preference created\n";
    echo "ID: " . $result->id . "\n";
    echo "Sandbox URL: " . $result->sandbox_init_point . "\n";
    echo "\n🎯 Test this URL with these cards:\n";
    echo "APPROVED: 4509 9535 6623 3704, Exp: 11/25, CVC: 123, Name: APRO\n";
    echo "REJECTED: 4000 0000 0000 0002, Exp: 11/25, CVC: 123, Name: OTHE\n";
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
