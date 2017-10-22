<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelusuarios extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	

	public function listar_autor($id){
		$this->db->select('id,nome,historico,img');
		$this->db->from('usuario');
		$this->db->where('id ='.$id);

		return $this->db->get()->result();
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
 