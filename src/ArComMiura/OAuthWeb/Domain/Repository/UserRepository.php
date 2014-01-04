<?php
namespace ArComMiura\OAuthWeb\Domain\Repository;

use Doctrine\ORM\EntityRepository as EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as Paginator;

class UserRepository extends EntityRepository
{
    public function getByNamePassword($name, $password)
    {
        $em = $this->_em;
        return $this->findOneBy(array(
            'name'=>$name,
            'password'=>$password
        ));
    }

    public function listUsers(array $pagination)
    {
        $em = $this->_em;

        $offset = $pagination['offset'];
        $limit = $pagination['limit'];

        $dql = "SELECT user FROM OAuth\Domain\Entities\User user";
        $query = $em->createQuery($dql);
        $query->setFirstResult($offset);
        $query->setMaxResults($limit);
        return new Paginator($query, false);
    }
}