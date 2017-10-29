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
    	+ Nesse caminho você poderá encnontrar o arquivo de configuração do neo4j, basta atualizar essas informações com as informações de sua base de dados.


# Project Status

## Desenvolvimento do projeto

Paginas                       |Status
------------------------------|------
home/index              	  | Publicações aparecendo OK.
home/categoria                | Publicações aparece por categoria OK.
home/sobrenos 				  | Falta atualizar texto em Lorem.
home/autor               	  | Falta implementar pagina para exibir informações de determinado autor.
home/contato                  | Falta implementar.
home/pesquisa                 | Falta implementar.
admin/index           		  | indefinido oque aparecerá nessa pagina.
admin/perfil                  | Falta implementar.
admin/categoria               | OK, apenas para administradores.
admin/categoria/alterar       | OK, apenas para administradores.
admin/categoria/excluir       | OK, apenas para administradores.
admin/publicacao              | OK.
admin/publicacao/alterar      | Falta implementar.
admin/publicacao/excluir      | Falta implementar.
admin/usuario                 | OK, apenas para administradores.


Implementações
================================


Nome                          | Descrição
------------------------------|------
Disqus              	      | Comentario para publicações





Caso de Uso
================================


![image do caso de uso](https://github.com/lucasjovencio/neo4j-blog/blob/master/docs/img/Blog.jpg)


Neo4j
================================

### Nodes

* `Usuario`
* `Categoria`
* `Publicacao`
* `Javascript`

### Relationships

* `(:Usuario)-[:publica {data:"2017-10-22T06:01"}]->(:Publicacao)`
* `(:Publicacao)-[:contidoEm]->(:Categoria)`
* `(:Publicacao)-[:extensaoBiblioteca]->(:Javascript)`

### Mudanças
+ Como o projeto está iniciando agora as relações e nodes estão sujeitas a mudanças assim como também a base de dados está sujeita a novos nodes e relacionamentos.