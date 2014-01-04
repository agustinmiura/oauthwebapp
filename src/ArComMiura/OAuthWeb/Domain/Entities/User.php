<?php

namespace ArComMiura\OAuthWeb\Domain\Entities;

use Doctrine\Mapping as ORM;

/**
 * @Entity(repositoryClass="ArComMiura\OAuthWeb\Domain\Repository\UserRepository")
 * @Table(name="oa_user")
 */
class User
{
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    const ROLE_ROOT =2;

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string $name
     *
     * @Column(name="name", type="string", length=45, nullable=false)
     */
    protected $name;

    /**
     * @var string $password
     *
     * @Column(name="password", type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @var string $role
     *
     * @Column(name="role", type="integer")
     */
    protected $role;

    public function __construct($name, $password, $role)
    {
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getName()
    {
        return $this->name;
    }

    public function changeName($name) 
    {
        $this->name = $name;
    }

    public function changePassword($password)
    {
        $this->password = $password;
    }

    function __toString()
    {
        $asString = print_r($this->toArray(), true);
        return $asString;
    }

    public function getRoleString() 
    {
        $roleMap = array(
            self::ROLE_USER=>'user',
            self::ROLE_ADMIN=>'admin',
            self::ROLE_ROOT=>'root'
        );
        return $roleMap[$this->role];
    }
    
    public function toArray()
    {
        $roleMap = array(
            self::ROLE_USER=>'User',
            self::ROLE_ADMIN=>'Admin',
            self::ROLE_ROOT=>'Root'
        );
        /*@todo fix
        $roleString = $roleMap[$this->role];

        $roleValueMap = array(
            self::ROLE_USER=>'ROLE_USER',
            self::ROLE_ADMIN=>'ROLE_ADMIN',
            self::ROLE_ROOT=>'ROLE_ROOT'
        );
        $roleValue = $roleValueMap[$this->role];
        */
        $roleString = '';
        return array(
            'id'=>$this->id,
            'name'=>$this->name,
            'password'=>'',
            'role'=>$this->role,
            'roleString'=>$roleString,
            'roleValue'=>$roleString
        );
    }
}