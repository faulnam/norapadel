<?php

$privateKeyPath = __DIR__ . '/storage/app/paylabs/private-key.pem';
$publicKeyPath = __DIR__ . '/storage/app/paylabs/public-key-correct.pem';

// Load private key
$privateKeyContent = file_get_contents($privateKeyPath);
$privateKey = openssl_pkey_get_private($privateKeyContent);

if ($privateKey === false) {
    die("Failed to load private key: " . openssl_error_string() . "\n");
}

// Extract public key
$publicKeyDetails = openssl_pkey_get_details($privateKey);
$publicKeyPem = $publicKeyDetails['key'];

// Save to file
file_put_contents($publicKeyPath, $publicKeyPem);

echo "Public key extracted successfully!\n";
echo "Saved to: $publicKeyPath\n\n";
echo "Public Key:\n";
echo $publicKeyPem;
echo "\n";

openssl_free_key($privateKey);
