<?php
namespace ArComMiura\OAuthWeb\Domain\Services;

use ArComMiura\OAuthWeb\Domain\Entities\User as UserEntity;
use Symfony\Component\HttpFoundation\Session\SessionInterface as SessionInterface;

interface IUserService
{
    public function findByUserPassword($user, $password);

    public function getCurrentUser(SessionInterface $session);
 
    public function findById($id);

    public function removeUser($id);

    public function createUser(UserEntity $user);

    public function updateUser($id, $newInformation);

    public function findByUsername($username);
}