<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/** 
 * @ORM\Entity
 */
class Adm implements JsonSerializable
{
   
    /** 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** 
     * @ORM\Column(type="string")
     */
    private $email;

    /** 
     * @ORM\Column(type="string")
     */
    private $senha;

    public function getId()
    {
        return $this->id;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "email" => $this->getEmail(),
            "senha" => $this->getSenha()
        ];
    }
}
