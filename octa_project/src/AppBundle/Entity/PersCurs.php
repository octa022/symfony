<?php

namespace AppBundle\Entity;

/**
 * PersCurs
 */
class PersCurs
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Cursos
     */
    private $cursos;

    /**
     * @var \AppBundle\Entity\Persona
     */
    private $persona;


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
     * Set cursos
     *
     * @param \AppBundle\Entity\Cursos $cursos
     *
     * @return PersCurs
     */
    public function setCursos(\AppBundle\Entity\Cursos $cursos = null)
    {
        $this->cursos = $cursos;

        return $this;
    }

    /**
     * Get cursos
     *
     * @return \AppBundle\Entity\Cursos
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return PersCurs
     */
    public function setPersona(\AppBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }
}

