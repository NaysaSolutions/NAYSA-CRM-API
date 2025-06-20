<?php
$$publicKeyPath = storage_path('keys/oauth-public.key');
$publicKey = file_get_contents($publicKeyPath);

$data = [
    "accreditation_id" => "123456",
    "application_id" => "app_001",
    "user_id" => "user_123",
    "password" => "securepassword"
];

// Generate a fixed auth_key for this request
$authKey = bin2hex(random_bytes(16));

// Encrypt using RSA Public Key
openssl_public_encrypt(json_encode($data), $encrypted, $publicKey);
$encryptedData = base64_encode($encrypted);

// Generate HMAC Hash using the same authKey
$hmac = hash_hmac('sha256', json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $authKey);

// Print values to send in Postman
echo json_encode([
    "encrypted_data" => $encryptedData,
    "hmac" => $hmac,
    "auth_key" => $authKey
], JSON_PRETTY_PRINT);

?>
