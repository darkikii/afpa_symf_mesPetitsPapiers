<?php
/*pas encore en fonctionnement*/
namespace App\Entity;

class CreationSearch
{
	private $type;

	public function getType(): ?String
	{
		return $this->type;
	}

	public function setType(String $recherche): CreationSearch
	{
		$this->type = $recherche;
		return $this;
	}

}