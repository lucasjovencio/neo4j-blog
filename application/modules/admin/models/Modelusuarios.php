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
        $query = 'MATCH (n:usuario) RETURN n.nome as nome, n.user as id, n.img as img, n.ativado as ativado ORDER BY n.nome';
        $result = $this->neo4j->get_db()->run($query);
        $lis = '';
        $cont=0;
		foreach ($result->records() as $record) {
            $lis[$cont]['nome'] = $record->value('nome');
            $lis[$cont]['id'] = $record->value('id');
            $lis[$cont]['img'] = $record->value('img');
            $lis[$cont]['ativado'] = $record->value('ativado');
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
				historico:{historico},
				direito:0,
				ativado:0
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
			RETURN us.nome as nome, us.user as id, us.img as img, us.historico as historico, us.email as email
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
			MATCH (us:usuario{user:{user}})
				where us.senha = {senha} and us.ativado=1
					return 
						us.user as user, us.img as img, us.historico as historico, us.email as email, us.direito as direito
		";
		$params = [
				'user'=>$user,
				'senha'=>md5($senha)
		];
		if($result = $this->neo4j->get_db()->run($query,$params)){
	        $lis = '';
	        $cont=0;
			foreach ($result->records() as $record) {
	            $lis[$cont]['result'] 		= 1;
	            $lis[$cont]['user'] 		= $record->value('user');
	            $lis[$cont]['img'] 			= $record->value('img');
	            $lis[$cont]['historico'] 	= $record->value('historico');
	            $lis[$cont]['email'] 		= $record->value('email');
	            $lis[$cont]['direito'] 		= $record->value('direito');
	            $cont++;
			}
			return $lis;
		}
		return $lis[0]['result']=0;
		
	}

	public function alterar($nome,$email,$historico,$user,$senha,$img){
		$params = [
				'user'=>$user,
				'novo_name'=>$nome,
				'novo_email'=>$email,
				'novo_historico'=>$historico,
				'novo_senha'=>md5($senha),
				'novo_img'=>$img
		];
		$query = "
			MATCH (us:usuario)
			where us.user = {user}
			SET us.nome = {novo_name},us.img = {novo_img},us.historico = {novo_historico},us.email = {novo_email},us.senha = {novo_senha}

			RETURN 1
		";

		if($this->neo4j->get_db()->run($query,$params)){
			return 1;
		}
		return 0;
	}

	public function desativar($id){
		$params = [
				'user'=>$id,
				'ativado'=>0
		];
		$query = "
			MATCH (us:usuario)
			where us.user = {user}
			SET us.ativado = {ativado}
			RETURN 1
		";

		if($this->neo4j->get_db()->run($query,$params)){
			return 1;
		}
		return 0;
	}
	public function ativar($id){
		$params = [
				'user'=>$id,
				'ativado'=>1
		];
		$query = "
			MATCH (us:usuario)
			where us.user = {user}
			SET us.ativado = {ativado}
			RETURN 1
		";

		if($this->neo4j->get_db()->run($query,$params)){
			return 1;
		}
		return 0;
	}
}
 