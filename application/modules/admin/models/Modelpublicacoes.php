<?php

class Modelpublicacoes extends Abstract_model{
    public function __construct() {
        parent::__construct();
    }
    
    public function listar_publicacao($pular,$post_por_pagina){

        $query = '
            MATCH (autor:usuario)-[w:publica]->(pub:publicacao)

            RETURN autor.nome as nome, 
                w.data as data,
                pub.titulo as titulo, 
                pub.subtitulo as subtitulo, 
                pub.conteudo as conteudo, 
                id(pub) as id,
                pub.img as img,
                pub.visivel as visivel
                ORDER BY pub.data DESC 
                SKIP {pular} 
                LIMIT {limit}
        ';
        $params = ['pular'=>intval($pular),'limit'=>intval($post_por_pagina)];
        if(($result = $this->neo4j->get_db()->run($query,$params))){
            $lis = '';
            $cont=0;
    		foreach ($result->records() as $record) {
                $lis[$cont]['autor'] = $record->value('nome');
                $lis[$cont]['titulo'] = $record->value('titulo');
                $lis[$cont]['subtitulo'] = $record->value('subtitulo');
                $lis[$cont]['conteudo'] = $record->value('conteudo');
                $lis[$cont]['data'] = $record->value('data');
                $lis[$cont]['visivel'] = $record->value('visivel');
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
            MATCH (pub:publicacao)

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
    public function alterar($titulo,$subtitulo,$conteudo,$date,$id,$cat,$url,$js,$id_user){
        $params = ['param' => intval($id)];
        $query = '
            MATCH (n:publicacao)
            where id(n) = {param}
            RETURN n.img as img
        ';
        if(($result = $this->neo4j->get_db()->run($query,$params))) {
            $lis = '';
            
            $lis[0]['img'] = $result->getRecord()->value('img');
        }

        $query = "
            match (aut:usuario)-[p:publica]->(pub:publicacao)
            where id(pub)={id} and  aut.user = {id_user}
            match (pub)-[cat:contidoEm]->(catt:categoria), (pub)-[jst:extensaoBiblioteca]->(jss:javascript)
            
            SET pub.modificado = 1
            delete jst,cat
            
            WITH COLLECT(distinct jss.name) as bib,
            COLLECT(distinct catt.name) as cate,
            aut,pub

            create (aut)-[mo:historico_mudanca{
                titulo:pub.titulo,
                subtitulo: pub.subtitulo,
                data:pub.data,
                dataModificacao:{dataMod},
                img:pub.img,
                javascript:bib,
                categoria:cate,
                visivel:1
            }]->(pub)

            SET pub.titulo = {titulo},
                pub.subtitulo = {subtitulo},
                pub.data = {data},
                pub.img = {url}
        ";
        
        $dateModi = new DateTime();
        $dataM = (string)$dateModi->format('Y-m-d H:i:s');
        $params = ['id' => intval($id),'id_user' => $id_user,'titulo'=>$titulo,'subtitulo'=>$subtitulo,'data'=>$date,'dataMod'=>$dataM,'url'=>$url];
        $this->neo4j->get_db()->run($query, $params);
        $stack = $this->neo4j->get_db()->stack();

        foreach ($cat as $key) {
            $query = "
                match (cat:categoria{name:{categoria}}), (pub:publicacao)
                where id(pub) = {idpub}
                MERGE (pub)-[:contidoEm]->(cat)
            ";
            $params = ['categoria'=>$key,'idpub'=>intval($id)];
            $stack->push($query, $params);
        };
        foreach ($js as $key) {
            $query = "
                match (jss:javascript{name:{js}}), (pub:publicacao)
                where id(pub) = {idpub}
                MERGE (pub)-[:extensaoBiblioteca]->(jss)
            ";
            $params = ['js'=>$key,'idpub'=>intval($id)];
            $stack->push($query, $params);
        };
        
        if($this->neo4j->get_db()->runStack($stack)){
            return $lis;
        }
        return 0;
    }
    public function excluir_publicacao($id){

        $params = ['param' => intval($id)];
        $query = '
            MATCH (n:publicacao)
            where id(n) = {param}
            RETURN n.img as img
        ';

        if(($result = $this->neo4j->get_db()->run($query,$params))) {
            $lis = '';
            
            $lis[0]['img'] = $result->getRecord()->value('img');
        }
        $query = '
            MATCH ()-[rt]->(n:publicacao)-[xt]->()
            where id(n) = {param}
            DELETE rt,xt,n
        ';
        if($this->neo4j->get_db()->run($query, $params)){
            return $lis;
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

    public function categoria_to_artigo($artigo,$all_categoria){
        $aux = '';
        $aux2 = '';
        $cont=0;
        $cont2=0;
        foreach ($artigo as $key) {
            
            $aux[$cont]=$key;

            $cont++;
        }

        foreach ($all_categoria as $key) {
            for ($i=0; $i < $cont ; $i++) { 
                if($key['name']===$aux[$i]){
                    $aux2[$cont2]['name']=$key['name'];
                    $aux2[$cont2]['selecionado']="selected";
                    break;
                }
                else{
                    $aux2[$cont2]['name']=$key['name'];
                    $aux2[$cont2]['selecionado']=" ";
                }
            }
            $cont2++;
        }
        return $aux2;
    }

    public function javascript_to_artigo($artigo,$all_javascript){
        $aux = '';
        $aux2 = '';
        $cont=0;
        $cont2=0;
        foreach ($artigo as $key) {
            
            $aux[$cont]=$key;

            $cont++;
        }
        
        foreach ($all_javascript as $key) {
            for ($i=0; $i < $cont ; $i++) { 
                if($key['name']===$aux[$i]){
                    $aux2[$cont2]['name']=$key['name'];
                    $aux2[$cont2]['selecionado']="selected";
                    break;
                }
                else{
                    $aux2[$cont2]['name']=$key['name'];
                    $aux2[$cont2]['selecionado']=" ";
                }
            }
            $cont2++;
        }
        return $aux2;
    }
}