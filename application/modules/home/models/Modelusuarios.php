<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelusuarios extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	

	public function listar_autor($id){
		$params = [
				'user'=> intval($id)
		];
		$query = "
			MATCH (us:usuario)
			where id(us) = {user}
			RETURN us.nome as nome, us.user as id, us.img as img, us.historico as historico, us.email as email
		";
		if($result = $this->neo4j->get_db()->run($query,$params)){
	        $lis = '';
	        $cont=0;
	        $lis[$cont]['nome'] = $result->getRecord()->value('nome');
	        $lis[$cont]['id'] = $result->getRecord()->value('id');
	        $lis[$cont]['img'] = $result->getRecord()->value('img');
	        $lis[$cont]['historico'] = $result->getRecord()->value('historico');
	        $lis[$cont]['email'] = $result->getRecord()->value('email');

	        return $lis;
		}
		return null;

	}

	public function listar_autores(){
        $query = 'MATCH (n:usuario) RETURN n.nome as nome, id(n) as id, n.img as img ORDER BY n.nomee';
        $result = $this->neo4j->get_db()->run($query);
        $lis = '';
        $cont=0;
		foreach ($result->records() as $record) {
            $lis[$cont]['nome'] = $record->value('nome');
            $lis[$cont]['id'] = $record->value('id');
            $lis[$cont]['img'] = $record->value('img');
            $cont++;
		}
        return $lis;
	}
}
 