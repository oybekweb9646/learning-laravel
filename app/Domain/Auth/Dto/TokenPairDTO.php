<?php

namespace App\Domain\Auth\Dto;

final readonly class TokenPairDTO
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
        public int    $expiresIn
    ) {}
}
