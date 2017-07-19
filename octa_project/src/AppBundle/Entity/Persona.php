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

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $telefono;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $persCurs;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuario;

    #protected $telefono;
    #protected $persCurs;

    /**
     * Constructor
     */

    public function __construct()
    {
        $this->telefono = new \Doctrine\Common\Collections\ArrayCollection();
        $this->persCurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    #public function __toString()
    #{
    #    return $this->nombre;
    #}

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

    /**
     * Add telefono
     *
     * @param \AppBundle\Entity\Telefono $telefono
     *
     * @return Persona
     */
    public function addTelefono(\AppBundle\Entity\Telefono $telefono)
    {
        $this->telefono[] = $telefono;

        return $this;
    }

    /**
     * Remove telefono
     *
     * @param \AppBundle\Entity\Telefono $telefono
     */
    public function removeTelefono(\AppBundle\Entity\Telefono $telefono)
    {
        $this->telefono->removeElement($telefono);
    }

    /**
     * Get telefono
     *
     * @return \Doctrine\Common\Collections\Collection
     */

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Add persCur
     *
     * @param \AppBundle\Entity\PersCurs $persCur
     *
     * @return Persona
     */
    public function addPersCur(\AppBundle\Entity\PersCurs $persCur)
    {
        $this->persCurs[] = $persCur;

        return $this;
    }

    /**
     * Remove persCur
     *
     * @param \AppBundle\Entity\PersCurs $persCur
     */
    public function removePersCur(\AppBundle\Entity\PersCurs $persCur)
    {
        $this->persCurs->removeElement($persCur);
    }

    /**
     * Get persCurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersCurs()
    {
        return $this->persCurs;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Persona
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}

