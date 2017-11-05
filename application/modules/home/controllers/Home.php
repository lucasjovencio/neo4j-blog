<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller{
    private $dados;
    private $foot;
    
	public function __construct(){
            parent::__construct();
            date_default_timezone_set('America/Sao_Paulo');
            $this->dados['onePublicacao']=0;
            $this->foot['onePublicacao']=0;
    }
    public function index($pular=null,$post_por_pagina=null){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");

        if(! $this->dados['categorias']   =   $this->modelcategorias->listar_categorias()){
            $this->dados['categorias'] = null;
        }
        if(!$pular){
            $pular=0;
        }

        /* Paginacao */
        $config['base_url']     = base_url("publicacao");
        $config['total_rows']   = $this->modelpublicacao->contar();
        $post_por_pagina = ( $config['total_rows'] > 5 ) ? 5 : $config['total_rows'];
        //echo $post_por_pagina;
        //die();
        $config['per_page']     = $post_por_pagina;
        /* FIM */

        //Dados a serem enviados ao cabeçalho


        $this->dados['titulo']    =   'Publicação';
        $this->dados['subtitulo'] =   'Recentes';
        $this->dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Publicação';
        $arr['subtitulo'] =   'Recentes';
        $arr['subtitulodb']   =  '';

        $arr['heardin']=$this->dados;

        if(!$arr['publicacoes']   =   $this->modelpublicacao->listar_publicacao($pular,$post_por_pagina)){
            $arr['publicacoes'] = null;
        }
        
        $arr['footerurl'] = $this->dados;
        $this->template->load("template_frontend/main","index",$arr);
    }
    public function publicacao($id,$slug){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");
        $this->dados['categorias']   =   $this->modelcategorias->listar_categorias();

        if(!$arr['publicacao']      =   $this->modelpublicacao->single_publicacao($id)){
            $arr['publicacao'] = null;
        }
        
       
        $this->dados['publicacaoCategorias'] = $arr['publicacao'][0]['categoria'];
        $this->dados['publicacaoJs'] = $arr['publicacao'][0]['javascript'];
        $this->dados['js'] = $arr['publicacao'][0]['urlJS'];

        $this->dados['onePublicacao']=1;
        $this->dados['onePublicacao']=1;

        //Dados a serem enviados ao cabeçalho


        $this->dados['titulo']    =   'Publicação';
        $this->dados['subtitulo'] =   $arr['publicacao'][0]['titulo'];
        $this->dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Publicação';
        $arr['subtitulo'] =   $arr['publicacao'][0]['titulo'];
        $arr['subtitulodb']   =  '';

        $arr['footerurl'] = $this->dados;

        $arr['heardin']=$this->dados;
        $this->template->load("template_frontend/main","publicacao",$arr);

    }
    public function categoria($slug,$id,$pular=null,$post_por_pagina=null){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");

        
        $this->dados['categorias']    =   $this->modelcategorias->listar_categorias();
        if(!$pular){
            $pular=0;
        }               

        /* Paginacao */
        $post_por_pagina = 2;//(null == $post_por_pagina) ? 2 : $post_por_pagina;
        ///
        $config['base_url']     = base_url('categoria/'.$slug.'/'.$id);
        $config['total_rows']   = $this->modelpublicacao->contar_por_categoria($id);
        $config['per_page']     = $post_por_pagina;
        

        $this->load->library('pagination');
        
        $this->pagination->initialize($config);

        $arr['links_paginacao'] = $this->pagination->create_links();

        /* FIM */
        

        if(!$arr['publicacoes']   =   $this->modelpublicacao->listar_publicacao_categoria($id,$pular,$post_por_pagina)){
            $arr['publicacoes'] = null;
            $this->dados['subtitulo']     =   'Não existem publicações para está categoria.';
            $arr['subtitulo']       =   'Não existem publicações para está categoria.';
        }else{
            $this->dados['subtitulo']     =   $arr['publicacoes'][0]['categoria'];
            $arr['subtitulo']       =   $arr['publicacoes'][0]['categoria'];
        }

        $this->dados['titulo']        =   'Publicações';
        $arr['titulo']          =   'Publicações';
        $arr['subtitulodb']     =  '';

        $arr['heardin']=$this->dados;
        $arr['footerurl'] = $this->dados;

        $this->template->load("template_frontend/main","categoria",$arr);
    }
    public function sobrenos(){
        $this->load->model("Modelusuarios","modelusuarios");
        $this->load->model("Modelcategorias","modelcategorias");

        
        $arr['autores'] =$this->modelusuarios->listar_autores();
        $this->dados['categorias']   =   $this->modelcategorias->listar_categorias();    

        
        $this->dados['titulo']    =   'Sobre Nos';
        $this->dados['subtitulo'] =   'Autores';
        $this->dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Sobre Nos';
        $arr['subtitulo'] =   'Autores';
        $arr['subtitulodb']   =  '';

        $arr['heardin']=$this->dados;
        $arr['footerurl'] = $this->dados;
        $this->template->load("template_frontend/main","sobrenos",$arr);
    }
    public function autor($id,$slug=null){

        $this->load->model("Modelcategorias","modelcategorias");
        $this->load->model("Modelusuarios","modelusuarios");
        $this->dados['categorias']   =   $this->modelcategorias->listar_categorias();
        $arr['autor'] =$this->modelusuarios->listar_autor($id);
       

        //Dados a serem enviados ao cabeçalho


        $this->dados['titulo']    =   'Autor';
        $this->dados['subtitulo'] =   $arr['autor'][0]['nome'];
        $this->dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Autor';
        $arr['subtitulo'] =   $arr['autor'][0]['nome'];
        $arr['subtitulodb']   =  '';


        $arr['footerurl'] = $this->dados;

        $arr['heardin']=$this->dados;
        $this->template->load("template_frontend/main","autor",$arr);
    }
}

/* End of file users.php */
/* Location: ./application/modules/home/controllers/Home.php */
