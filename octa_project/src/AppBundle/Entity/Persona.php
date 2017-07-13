<?php

namespace AppBundle\Entity;

/**
 * Persona
 */
class Persona
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellido;


    /************ Propiedad ************/
    protected $usuario;
    protected $telefono;
    protected $persCurs;
    
    public function __construct()
    {
        $this->telefono = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->persCurs = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /********************************/
    //protected $usuario;

    //public function __construct()
    //{
    //    $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
    //}
    /********************************/


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Persona
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Persona
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /*Extraer los Numeros de Una Persona*/
    public function getTelefono()
    {
        return $this->telefono;
    }
    /***************************/ 
    /*Extraer Usuario de Una Persona*/
    public function getUsuario()
    {
        return $this->usuario;
    }
    /***************************/ 
    public function getPersCurs()
    {
        return $this->persCurs;
    }
    /***************************/ 
}

