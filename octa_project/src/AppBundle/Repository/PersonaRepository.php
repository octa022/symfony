<?php
namespace AppBundle\Repository;
use AppBundle\Entity\Telefono;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Usuario;


class PersonaRepository extends \Doctrine\ORM\EntityRepository
{
	public function saveDatos($nombre,$apellido,$telefono=null,$persona=null,$user=null)
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

		#$usuario = new Usuario();
		#$usuario->setUsuario($persona);
		#$usuario->setUser($user);
		
		$telefonos = new Telefono();
		$telefonos->setPersona($persona);
		$telefonos->setNumero($telefono);
		$em->persist($telefonos);
		//$em->persist($usuario);

		$flush=$em->flush();
		return $flush;


	}

}
