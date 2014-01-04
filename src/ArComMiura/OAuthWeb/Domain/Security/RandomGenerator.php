<?php
 
namespace ArComMiura\OAuthWeb\Domain\Security;

class RandomGenerator 
implements \ArComMiura\OAuthWeb\Domain\Security\IRandomGenerator 
{
    public function getString() 
    {
        return (md5(rand()));
    }
}