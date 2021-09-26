<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/** 
 * @ORM\Entity
 */
class Publicacao implements \JsonSerializable
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
    private $titulo;

    /** 
     * @ORM\Column(type="text")
     */
    private $texto;

    /** 
     * @ORM\Column(type="string")
     */
    private $categoria;

    /** 
     * @ORM\Column(type="string")
     */
    private $nomeFoto;

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNomeFoto()
    {
        return $this->nomeFoto;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    // Setters

    public function setNomeFoto($nomeFoto)
    {
        $this->nomeFoto = $nomeFoto;

        return $this;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "id"=> $this->getId(),
            "titulo"=>$this->getTitulo(),
            "texto"=>$this->getTexto(),
            "categoria"=>$this->getCategoria(),
            "nomeFoto"=>$this->getNomeFoto(),
        ];
    }
}
