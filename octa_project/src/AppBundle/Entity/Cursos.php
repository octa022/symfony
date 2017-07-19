<?php

namespace AppBundle\Entity;

/**
 * Cursos
 */
class Cursos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombreCurso;

    /**
     * @var string
     */
    private $tutor;

    /**
     * @var string
     */
    private $descripcion;

    /************ Propiedad ************/
    protected $persCurs; 
       
    public function __construct()
    {
        $this->persCurs = new \Doctrine\Common\Collections\ArrayCollection();
    }
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
     * Set nombreCurso
     *
     * @param string $nombreCurso
     *
     * @return Cursos
     */
    public function setNombreCurso($nombreCurso)
    {
        $this->nombreCurso = $nombreCurso;

        return $this;
    }

    /**
     * Get nombreCurso
     *
     * @return string
     */
    public function getNombreCurso()
    {
        return $this->nombreCurso;
    }

    /**
     * Set tutor
     *
     * @param string $tutor
     *
     * @return Cursos
     */
    public function setTutor($tutor)
    {
        $this->tutor = $tutor;

        return $this;
    }

    /**
     * Get tutor
     *
     * @return string
     */
    public function getTutor()
    {
        return $this->tutor;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Cursos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /*Extraer Cursos de Una Persona*/
    /***************************/ 
    public function getPersCurs()
    {
        return $this->persCurs;
    }
    /***************************/ 
}
