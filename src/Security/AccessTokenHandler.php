<?php

namespace App\Security;

use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
        public function getUserBadgeFrom(string $accessToken):
        UserBadge
        {
                
                
                if (null === $accessToken || !$accessToken->isValid()) {
                        throw new BadCredentialsException('Invalid credentials.');
                }
        
                // and return a UserBadge object containing the user identifier from the found token
                return new UserBadge($accessToken->getUserId());
        }
}