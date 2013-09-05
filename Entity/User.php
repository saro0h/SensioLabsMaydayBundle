<?php

namespace SensioLabs\Bundle\MaydayBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SensioLabs\Connect\Api\Api;
use SensioLabs\Connect\Api\Entity\User as ConnectUser;

/**
 * Represents a connect user.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @ORM\Table(name="mayday_user")
 * @ORM\Entity(repositoryClass="SensioLabs\Bundle\MaydayBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $profile;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Kiss", mappedBy="user")
     */
    private $kisses;

    /**
     * @param ConnectUser $connectUser
     */
    public function __construct(ConnectUser $connectUser)
    {
        $this->uuid = $connectUser->get('uuid');
        $this->kisses = new ArrayCollection();
    }

    /**
     * Returns user as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->username;
    }

    /**
     * Updates user with the given connect user.
     *
     * @param ConnectUser $connectUser
     *
     * @return User
     *
     * @throws \InvalidArgumentException
     */
    public function update(ConnectUser $connectUser)
    {
        if ($this->uuid !== $connectUser->get('uuid')) {
            throw new \InvalidArgumentException('You try to update the wrong user.');
        }

        $this->username = $connectUser->get('username');
        $this->email = $connectUser->get('email');
        $this->picture = sprintf('https://connect.sensiolabs.com/api/images/%s.png', $this->uuid);
        $this->profile = sprintf('https://connect.sensiolabs.com/profile/%s', $this->username);

        return $this;
    }

    /**
     * Returns user as an array.
     *
     * @return string[]
     */
    public function asArray()
    {
        return array(
            'uuid'     => $this->uuid,
            'username' => $this->username,
            'email'    => $this->email,
            'picture'  => $this->picture,
            'profile'  => $this->profile,
            'kisses'   => $this->kisses->map(function (Kiss $kiss) { return $kiss->asArray(); }),
        );
    }
}
