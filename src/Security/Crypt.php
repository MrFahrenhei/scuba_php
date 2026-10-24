<?php

namespace ScubaPHP\Security;

class Crypt
{
    private const CIPHER = 'aes-256-gcm';
    private const IV_LENGTH = 12;
    private const TAG_LENGTH = 16;

    private string $key;

    public function __construct(string $key)
    {
        $this->key = base64_decode($key, true) ?: '';

        if (strlen($this->key) !== 32) {
            throw new \InvalidArgumentException('APP_KEY deve ter 32 bytes em base64.');
        }
    }

    public function encrypt(string $value): string
    {
        $iv = random_bytes(self::IV_LENGTH);
        $cipher = openssl_encrypt($value, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv, $tag, '', self::TAG_LENGTH);

        return rtrim(strtr(base64_encode($iv . $tag . $cipher), '+/', '-_'), '=');
    }

    public function decrypt(string $token): string|false
    {
        $raw = base64_decode(strtr($token, '-_', '+/'), true);

        if ($raw === false || strlen($raw) <= self::IV_LENGTH + self::TAG_LENGTH) {
            return false;
        }

        $iv = substr($raw, 0, self::IV_LENGTH);
        $tag = substr($raw, self::IV_LENGTH, self::TAG_LENGTH);
        $cipher = substr($raw, self::IV_LENGTH + self::TAG_LENGTH);

        return openssl_decrypt($cipher, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv, $tag);
    }
}
