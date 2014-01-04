<?php
namespace ArComMiura\OAuthWeb\Domain\Services;

use Doctrine\ORM\EntityManager as EntityManager;

abstract class AbstractService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}