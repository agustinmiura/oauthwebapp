<?php
namespace ArComMiura\OAuthWeb\Domain\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface as SessionInterface;

use ArComMiura\OAuthWeb\Domain\Services\AbstractService as AbstractService;
use ArComMiura\OAuthWeb\Domain\Entities\User as User;

class UserServiceImpl extends AbstractService implements IUserService
{

    /**
     * 
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function createUser(User $user) 
    {
        $em = $this->em;
        $em->persist($user);
    }

    /**
     *
     * @todo fix
     * 
     * @param  [type] $user     [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function findByUserPassword($user, $password)
    {
        $em = $this->em;
        $repository = $em->getRepository('ArComMiura\OAuthWeb\Domain\Entities\User');
        $found = $repository->getByNamePassword($user, $password);

        $logger = \Logger::getLogger('MyLogger');
        $logger->debug('Called debug method in find by user password');
        $logger->debug('(user, password)'.'('.$user.','.$password.')');
        $asString = print_r($found, true);
        $logger->debug('The found is :'.$asString);

        return $found;
    }

    /**
     *  @todo fix
     * 
     * @param  SessionInterface $session [description]
     * @return [type]                    [description]
     */
    public function getCurrentUser(SessionInterface $session)
    {
        $user = null;
        if ($session!==null) {
            $user = $session->get('user');
        }
        return $user;
    }

    /**
     * @todo fix
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function findById($id)
    {
        $em = $this->em;
        $repository = $em->getRepository(
            'ArComMiura\OAuthWeb\Domain\Entities\User'
        );
        return $repository->findOneBy(array(
            'id'=>$id
        ));
    }

    /**
     * @todo  fix
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    private function _removeUser(User $user)
    {
        $em = $this->em;
        $em->remove($user);
    }

    /**
     * @todo fix
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function removeUser($id)
    {
        $em = $this->em;
        $repository = $em->getRepository(
            'ArComMiura\OAuthWeb\Domain\Entities\User'
        );

        $user = $repository->findOneBy(array(
            'id'=>$id
        ));

        $this->_removeUser($user);
    }

    /**
     * @todo fix
     * @param  [type] $id             [description]
     * @param  [type] $newInformation [description]
     * @return [type]                 [description]
     */
    public function updateUser($id, $newInformation)
    {
        $em = $this->em;
        $repository = $em->getRepository(
            'ArComMiura\OAuthWeb\Domain\Entities\User'
        );
        
        $user = $repository->findOneBy(array("id"=>$id));

        $em->persist($user);
    }

    public function findByUsername($username)
    {
        return $repository->findOneBy(array('name'=>$username));
    }
}