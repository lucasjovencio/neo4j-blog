Neo4j + Codeigniter 3 Padrão HMVC
================================

Muitas pessoas querem conhecer Neo4j sobre pretexto de usar em seus projetos para analise de dados, sistema de recomendações, redes sociais  e as vezes como hobby apenas para aprender uma metodologia diferente de armazenamentos de dados. Este projeto tem como objetivo reunir todas as pessoas em apenas um lugar para compartilharem experiências, melhores praticas no desenvolvimento e duvidas sobre o neo4j. 

Fase de Desenvolvimento
================================

+ Requisits System  
  + PHP >=5.6  
  + NEO4J >= 3.*
  + Linux distribuições baseado em Debian or Windows

+ FrameWork de desenvolvimento
	+ Codeigniter 3.1.6
	+ Porque não usar wordpress que tem um sistema de gerenciamento de colaborador/postagens completo ?
		+ A resposta é: Porque o objetivo não é apenas ser mais um site falando sobre algo, o próprio site é baseado no tema de discursão. Quando alguém aprender algo em algum artigo do site e quiser desenvolver em cima do blog, basta pega o código de site e se aventurar. A comunidade não está presa em apenas publicar artigos para propor soluções. As pessoas poderão interagir diretamente com o código fonte sugerindo melhorias com base no conhecimento adquirido ou já existente.


+ Arquivo de configuração Neo4j  
    + application/libraries/Neo4j.php 
    	+ Nesse caminho você poderá encnontrar o arquivo de configuração do neo4j, basta atualizar essas informações com as informações de sua base da dos.


# Project Status

## Desenvolvimento do projeto

Paginas                       |Status
------------------------------|------
home/index              	  | Publicações aparecendo OK, falta corrigir erro que aparece quando não tem publicações ou categoria.
home/categoria                | Publicações aparece por categoria OK, falta corrigir erro que aparece quando não tem publicações.
home/sobrenos 				  | Falta atualizar texto em Lorem.
home/autor               	  | Falta criar pagina para exibir informações de determinado autor.
home/contato                  | Falta criar.
home/pesquisa                 | Falta implementar.
admin/index           		  | indefinidor oque aparecerá nessa pagina ainda.
admin/categoria               | OK
admin/categoria/alterar       | OK
admin/categoria/excluir       | OK
admin/publicacao              | Falta adicionar checklist de javascripts que o autor deseja carregar, torna select categoria em checklist também.
admin/publicacao/alterar      | Falta adicionar checklist de javascripts que o autor deseja carregar, torna select categoria em checklist também.
admin/publicacao/excluir      | OK
admin/usuario                 | OK, apenas para administradores


Implementações
================================


Nome                          | Descrição
------------------------------|------
Disquis              	      | Comentario para publicações





Caso de Uso
================================


![image do caso de uso](https://github.com/lucasjovencio/neo4j-blog/blob/master/docs/img/Blog.jpg)


Neo4j
================================

### Nodes

* `Usuario`
* `Categoria`
* `Publicacao`



### Relationships

* `(:Usuario)-[:publica {data:"2017-10-22T06:01"}]->(:Publicacao)`
* `(:Publicacao)-[:contidoEm]->(:Categoria)`

### Mudanças
+ Como o projeto está iniciando agora as relações e nodes estão sujeitas a mudanças assim como também a base de dados está sujeita a novos nodes e relacionamentos.