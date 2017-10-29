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
        if($result = $this->neo4j->get_db()->run($query,$params)){
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
        return null;
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
        if($result = $this->neo4j->get_db()->run($query,$params)){
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
        return null;
    }
    public function single_publicacao($id){

        $query = '
            MATCH (pub:publicacao)
            WHERE ID(pub) = {param}
            MATCH (autor:usuario)-[w:publica]->(pub)-[r:contidoEm]->(cat:categoria), (pub)-[rr:extensaoBiblioteca]->(bib:javascript)
                RETURN autor.nome as nome, 
                    w.data as data,
                    pub.titulo as titulo, 
                    pub.subtitulo as subtitulo, 
                    pub.conteudo as conteudo, 
                    
                    id(pub) as id, 
                    pub.img as img,
                    id(autor) as id_autor,
                    autor.nome as nome_autor,
                    COLLECT(distinct bib.name) as js,
                    COLLECT(distinct bib.url) as urlbib,
                    COLLECT(distinct cat.name) as cat
        ';
        $params = ['param'=>intval($id)];
        if(($result = $this->neo4j->get_db()->run($query,$params))){
            $lis = '';

            $lis[0]['autor'] =$result->getRecord()->value('nome');
            $lis[0]['titulo'] =$result->getRecord()->value('titulo');
            $lis[0]['subtitulo'] =$result->getRecord()->value('subtitulo');
            $lis[0]['conteudo'] =$result->getRecord()->value('conteudo');
            $lis[0]['data'] =$result->getRecord()->value('data');
            $lis[0]['id'] =$result->getRecord()->value('id');
            $lis[0]['id_autor']=$result->getRecord()->value('id_autor');
            $lis[0]['nome_autor']=$result->getRecord()->value('nome_autor');

            $lis[0]['categoria'] =$result->getRecord()->value('cat');
            $lis[0]['javascript'] =$result->getRecord()->value('js');
            $lis[0]['urlJS'] =$result->getRecord()->value('urlbib');
            if($result->getRecord()->value('img') !=null){                
                $lis[0]['img'] =$result->getRecord()->value('img');
            }else{
                $lis[0]['img'] = 'null';
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