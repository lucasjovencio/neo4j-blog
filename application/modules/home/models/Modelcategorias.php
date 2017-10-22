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
}