<?php

class Modelpublicacoes extends Abstract_model{
    public function __construct() {
        parent::__construct();
    }
    
    public function listar_publicacao($pular,$post_por_pagina){

        $query = '
            MATCH (autor:usuario)-[w:publica]->(pub:publicacao)-[r:contidoEm]->(cat:categoria)

            RETURN autor.nome as nome, 
                w.data as data,
                pub.titulo as titulo, 
                pub.subtitulo as subtitulo, 
                pub.conteudo as conteudo, 
                cat.name as name, 
                id(pub) as id, 
                pub.img as img
                ORDER BY pub.titulo 
                SKIP {pular} 
                LIMIT {limit}
        ';
        $params = ['pular'=>intval($pular),'limit'=>$post_por_pagina];
        if(($result = $this->neo4j->get_db()->run($query,$params))){
            $lis = '';
            $cont=0;
    		foreach ($result->records() as $record) {
                $lis[$cont]['autor'] = $record->value('nome');
                $lis[$cont]['titulo'] = $record->value('titulo');
                $lis[$cont]['categoria'] = $record->value('name');
                $lis[$cont]['subtitulo'] = $record->value('subtitulo');
                $lis[$cont]['conteudo'] = $record->value('conteudo');
                $lis[$cont]['data'] = $record->value('data');
                $lis[$cont]['id'] = $record->value('id');
                $lis[$cont]['img'] = $record->value('img');
                $cont++;
    		}
            return $lis;
        }
        return null;
    }
    public function contar(){
        $query = '
            MATCH (autor:usuario)-[w:publica]->(pub:publicacao)-[r:contidoEm]->(cat:categoria)

            RETURN count(pub) as id
        ';
        $result = $this->neo4j->get_db()->run($query);

        $lis = '';
        $cont=0;
        foreach ($result->records() as $record) {
            $lis[$cont]['id'] = $record->value('id');
            $cont++;
        }
        return intval($lis[0]['id']);
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
    public function adicionar($titulo,$subtitulo,$conteudo,$date,$id,$cat,$url,$java){
        $query = "
            match (autor:usuario{user:{username}})
            create (pub:publicacao{
                titulo:{titulo},
                subtitulo:{subtitulo},
                img:{url},
                conteudo:{conteudo}
            })
            MERGE (autor)-[:publica{data:{date}}]->(pub)
            return id(pub) as id
        ";

        $params = ['titulo'=>$titulo,'subtitulo'=>$subtitulo,'conteudo'=>$conteudo,'date'=>$date,'username'=>$id,'url'=>$url];
        if($result=$this->neo4j->get_db()->run($query, $params)){

            $idpub= $result->getRecord()->value("id");
            $query='';
            $result = NULL;
            $stack = $this->neo4j->get_db()->stack();
            

            foreach ($cat as $key) {
                $query = "
                    match (cat:categoria{name:{categoria}}), (pub:publicacao)
                    where id(pub) = {idpub}
                    MERGE (pub)-[:contidoEm]->(cat)
                ";
                $params = ['categoria'=>$key,'idpub'=>$idpub];
                $stack->push($query, $params);
            };
            foreach ($java as $key) {
                $query = "
                    match (jss:javascript{name:{js}}), (pub:publicacao)
                    where id(pub) = {idpub}
                    MERGE (pub)-[:extensaoBiblioteca]->(jss)
                ";
                $params = ['js'=>$key,'idpub'=>$idpub];
                $stack->push($query, $params);
            };
            if($this->neo4j->get_db()->runStack($stack)){
                return 1;
            }
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