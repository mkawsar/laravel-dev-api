<?php

namespace App\Http\Traits;

trait UuidGenerateTrait
{
    public function uuid()
    {
        return sprintf('%s-%s-%04x-%04x-%s',
            bin2hex(openssl_random_pseudo_bytes(4)),
            bin2hex(openssl_random_pseudo_bytes(2)),
            hexdec(bin2hex(openssl_random_pseudo_bytes(2))) & 0x0fff | 0x4000,
            hexdec(bin2hex(openssl_random_pseudo_bytes(2))) & 0x3fff | 0x8000,
            bin2hex(openssl_random_pseudo_bytes(6))
        );
    }
}
