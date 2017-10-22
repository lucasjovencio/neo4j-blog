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
        $params = ['pular'=>intval($pular),'limit'=>2];
        $result = $this->neo4j->get_db()->run($query,$params);
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
            if($record->value('img') !='null'){                
                $lis[$cont]['img'] = $record->value('img');
            }else{
                $lis[$cont]['img'] = 'null';
            }
            
            $cont++;
		}

        return $lis;
    }
    public function listar_publicacao_categoria($id,$pular,$post_por_pagina){
        $query = '
            MATCH (cat:categoria)
            WHERE id(cat)={id}
            MATCH (cat)<-[r:contidoEm]-(pub:publicacao)<-[w:publica]-(autor:usuario) 
                RETURN autor.nome as nome, 
                w.data as data,
                pub.titulo as titulo, 
                pub.subtitulo as subtitulo, 
                pub.conteudo as conteudo, 
                cat.name as name, 
                id(pub) as id, 
                pub.img as img,
                id(autor) as id_autor,
                autor.nome as nome_autor
                ORDER BY pub.titulo
                SKIP {pular} 
                LIMIT {limit}
        ';
        $params = ['pular'=>intval($pular),'limit'=>2,'id'=>intval($id)];
        $result = $this->neo4j->get_db()->run($query,$params);
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
            if($record->value('img') !='null'){                
                $lis[$cont]['img'] = $record->value('img');
            }else{
                $lis[$cont]['img'] = 'null';
            }
            $cont++;
        }

        return $lis;
    }
    public function single_publicacao($id){

        $query = '
            MATCH (pub:publicacao)
            WHERE ID(pub) = {param}
            MATCH (autor:usuario)-[w:publica]->(pub)-[r:contidoEm]->(cat:categoria)
                RETURN autor.nome as nome, 
                    w.data as data,
                    pub.titulo as titulo, 
                    pub.subtitulo as subtitulo, 
                    pub.conteudo as conteudo, 
                    cat.name as name, 
                    id(pub) as id, 
                    pub.img as img,
                    id(autor) as id_autor,
                    autor.nome as nome_autor
        ';
        $params = ['param'=>intval($id)];
        $result = $this->neo4j->get_db()->run($query,$params);
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
            $lis[$cont]['id_autor']=$record->value('id_autor');
            $lis[$cont]['nome_autor']=$record->value('nome_autor');
            if($record->value('img') !=null){                
                $lis[$cont]['img'] = $record->value('img');
            }else{
                $lis[$cont]['img'] = 'null';
            }
            
            $cont++;
        }

        return $lis;
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
    public function contar_por_categoria($id){
        $query = '
            MATCH (cat:categoria)
            where id(cat)={id}
            MATCH (cat)<-[r:contidoEm]-(pub:publicacao)<-[w:publica]-(autor:usuario) 
            RETURN count(pub) as cont
        ';
        $params = ['id'=>intval($id)];
        $result = $this->neo4j->get_db()->run($query,$params);

        $lis = '';
        $cont=0;
        foreach ($result->records() as $record) {
            $lis[$cont]['cont'] = $record->value('cont');
            $cont++;
        }
        return intval($lis[0]['cont']);
    }
}