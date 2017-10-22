<?php

class Modelcategorias extends Abstract_model{
    public function __construct() {
        parent::__construct();
    }
    
    public function listar_categorias(){
        $query = 'MATCH (n:categoria) RETURN n.name as name, id(n) as id  ORDER BY n.name';
        $result = $this->neo4j->get_db()->run($query);
        $lis = '';
        $cont=0;
		foreach ($result->records() as $record) {
            $lis[$cont]['name'] = $record->value('name');
            $lis[$cont]['id'] = $record->value('id');
            $cont++;
		}
        return $lis;
    }
    public function verifica_existencia_categoria($name){
        $query = 'MATCH (n:categoria{name:{param}}) RETURN count(n) as cont';
        
        $params = ['param' => $name];
        $result = $this->neo4j->get_db()->run($query, $params);
        $lis = '';
        $cont=0;
        foreach ($result->records() as $record) {
            $lis[$cont]['cont'] = $record->value('cont');
            $cont++;
        }
        if($lis[0]['cont']==1){
            return 1;
        }
        return 0;
    }
    public function adicionar($name){
        $query = 'CREATE (categoria:categoria{name:{param}})';
        $params = ['param' => $name];
        if($this->neo4j->get_db()->run($query, $params)){
            return 1;
        }
        return 0;
    }
    public function alterar($name,$id){
        $query = 'MATCH (n:categoria{ name: {param}})
        SET n.name = {novo_name} RETURN count(n) as cont';
        $params = ['param' => $id,'novo_name' => $name];

        if($this->neo4j->get_db()->run($query, $params)){
            return 1;
        }
        return 0;
    }
    public function excluir($id){
        $query = 'MATCH (n:categoria{name: {param} })
                    DELETE n RETURN 1
        ';
        $params = ['param' => $id];

        if($this->neo4j->get_db()->run($query, $params)){
            return 1;
        }
        return 0;
    }
}