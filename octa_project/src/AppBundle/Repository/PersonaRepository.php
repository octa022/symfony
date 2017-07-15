<?php
namespace AppBundle\Repository;
use AppBundle\Entity\Telefono;
use AppBundle\Entity\Persona;

class PersonaRepository extends \Doctrine\ORM\EntityRepository
{
	public function saveTelefono($nombre,$apellido,$telefono=null,$persona=null)
	{
		$em=$this->getEntityManager();

		$telefono_repo=$em->getRepository("AppBundle:Telefono");

		if($persona==null)
		{
			$persona=$this->findOneBy(array("nombre"=>$nombre,
				"apellido"=>$apellido,
				//"numero"=>$numero
			));
		}
		else{}
		//$telefono=

		$telefonos = new Telefono();
		$telefonos->setPersona($persona);
		$telefonos->setNumero($telefono);
		$em->persist($telefonos);

		$flush=$em->flush();
		return $flush;


	}

}
