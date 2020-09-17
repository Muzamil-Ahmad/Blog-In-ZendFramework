<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userregistration
 *
 * @ORM\Table(name="userregistration", indexes={@ORM\Index(name="userid", columns={"userid"})})
 * @ORM\Entity
 */
class Userregistration
{
    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=500, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneno", type="string", length=100, nullable=true)
     */
    private $phoneno;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=50, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=200, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=200, nullable=true)
     */
    private $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="profile", type="string", length=600, nullable=true)
     */
    private $profile;



    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Userregistration
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Userregistration
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Userregistration
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phoneno
     *
     * @param string $phoneno
     *
     * @return Userregistration
     */
    public function setPhoneno($phoneno)
    {
        $this->phoneno = $phoneno;

        return $this;
    }

    /**
     * Get phoneno
     *
     * @return string
     */
    public function getPhoneno()
    {
        return $this->phoneno;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Userregistration
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Userregistration
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set profession
     *
     * @param string $profession
     *
     * @return Userregistration
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set profile
     *
     * @param string $profile
     *
     * @return Userregistration
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
