<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelusuarios extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	

    public function contar(){
        $query = '
            MATCH (autor:usuario)
            RETURN count(autor) as cont
        ';
        $result = $this->neo4j->get_db()->run($query);

        $lis = '';
        $cont=0;
        foreach ($result->records() as $record) {
            $lis[$cont]['cont'] = $record->value('cont');
            $cont++;
        }
        return intval($lis[0]['cont']);
    }
	public function listar_autores(){
        $query = 'MATCH (n:usuario) RETURN n.nome as nome, n.user as id, n.img as img ORDER BY n.nome';
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
	public function adicionar($nome,$email,$historico,$user,$senha,$img){
		$params = [
				'senha'=>md5($senha),
				'nome'=>$nome,
				'email'=>$email,
				'user'=>$user,
				'img'=>$img,
				'historico'=>$historico
		];
		$query = "
			CREATE (us:usuario{
				nome:{nome},
				senha:{senha},
				email:{email},
				user:{user},
				img:{img},
				historico:{historico}
			})
		";
		if($this->neo4j->get_db()->run($query, $params)){
            return 1;
        }
        return 0;
	}
	public function usuario_detalhes($user){
		$params = [
				'user'=>$user
		];
		$query = "
			MATCH (us:usuario{
				user:{user}
			})
			RETURN n.nome as nome, n.user as id, n.img as img, n.historico as historico, n.email as email
		";
		$result = $this->neo4j->get_db()->run($query,$params);
        $lis = '';
        $cont=0;
		foreach ($result->records() as $record) {
            $lis[$cont]['nome'] = $record->value('nome');
            $lis[$cont]['id'] = $record->value('id');
            $lis[$cont]['img'] = $record->value('img');
            $lis[$cont]['historico'] = $record->value('historico');
            $lis[$cont]['email'] = $record->value('email');
            $cont++;
		}
        return $lis;
	}

	public function verificar_login($user,$senha){
		$query = "
			MATCH (us:usuario)
			RETURN
				CASE
				  WHEN us.user = {user} and us.senha = {senha}
				    THEN 1
				  ELSE 0
				END AS result, us.user as user, us.img as img, us.historico as historico, us.email as email
		";
		$params = [
				'user'=>$user,
				'senha'=>md5($senha)
		];
		$result = $this->neo4j->get_db()->run($query,$params);
        $lis = '';
        $cont=0;
		foreach ($result->records() as $record) {
            $lis[$cont]['result'] 		= $record->value('result');
            $lis[$cont]['user'] 		= $record->value('user');
            $lis[$cont]['img'] 			= $record->value('img');
            $lis[$cont]['historico'] 	= $record->value('historico');
            $lis[$cont]['email'] 		= $record->value('email');
            $cont++;
		}

		return $lis;
	}
}
 