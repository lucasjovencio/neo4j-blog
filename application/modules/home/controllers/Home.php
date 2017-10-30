<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller{
	public function __construct(){
            parent::__construct();
            date_default_timezone_set('America/Sao_Paulo');

    }
    public function index($pular=null,$post_por_pagina=null){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");

        $dados['onePublicacao']=0;
        $foot['onePublicacao']=0;

        if(! $dados['categorias']   =   $this->modelcategorias->listar_categorias()){
            $dados['categorias'] = null;
        }
        if(!$pular){
            $pular=0;
        }

        /* Paginacao */
        $post_por_pagina = 2;//(null == $post_por_pagina) ? 2 : $post_por_pagina;
        $config['base_url']     = base_url("publicacao");
        $config['total_rows']   = $this->modelpublicacao->contar();
        $config['per_page']     = $post_por_pagina;
        /* FIM */

        //Dados a serem enviados ao cabeçalho


        $dados['titulo']    =   'Publicação';
        $dados['subtitulo'] =   'Recentes';
        $dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Publicação';
        $arr['subtitulo'] =   'Recentes';
        $arr['subtitulodb']   =  '';

        $arr['heardin']=$dados;

        if(!$arr['publicacoes']   =   $this->modelpublicacao->listar_publicacao($pular,$post_por_pagina)){
            $arr['publicacoes'] = null;
        }
        
    

        $arr['footerurl'] = $foot;
        $this->template->load("template_frontend/main","index",$arr);
    }
    public function publicacao($id,$slug){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");
        $dados['categorias']   =   $this->modelcategorias->listar_categorias();

        if(!$arr['publicacao']      =   $this->modelpublicacao->single_publicacao($id)){
            $arr['publicacao'] = null;
        }
        
       
        $dados['publicacaoCategorias'] = $arr['publicacao'][0]['categoria'];
        $dados['publicacaoJs'] = $arr['publicacao'][0]['javascript'];
        $foot['js'] = $arr['publicacao'][0]['urlJS'];

        $dados['onePublicacao']=1;
        $foot['onePublicacao']=1;

        //Dados a serem enviados ao cabeçalho


        $dados['titulo']    =   'Publicação';
        $dados['subtitulo'] =   $arr['publicacao'][0]['titulo'];
        $dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Publicação';
        $arr['subtitulo'] =   $arr['publicacao'][0]['titulo'];
        $arr['subtitulodb']   =  '';

        $arr['footerurl'] = $foot;

        $arr['heardin']=$dados;
        $this->template->load("template_frontend/main","publicacao",$arr);

    }
    public function categoria($slug,$id,$pular=null,$post_por_pagina=null){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");

        $dados['onePublicacao']=0;
        $foot['onePublicacao']=0;

        $dados['categorias']    =   $this->modelcategorias->listar_categorias();
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
        
        $arr['publicacoes']    =   $this->modelpublicacao->listar_publicacao_categoria($id,$pular,$post_por_pagina);

        $dados['titulo']        =   'Publicações';
        $dados['subtitulo']     =   $arr['publicacoes'][0]['categoria'];
        $dados['subtitulodb']   =  '';
        $arr['titulo']          =   'Publicações';
        $arr['subtitulo']       =   $arr['publicacoes'][0]['categoria'];
        $arr['subtitulodb']     =  '';

        $arr['heardin']=$dados;
        $arr['footerurl'] = $foot;
        $this->template->load("template_frontend/main","categoria",$arr);
    }
    public function sobrenos(){
        $this->load->model("Modelusuarios","modelusuarios");
        $this->load->model("Modelcategorias","modelcategorias");
        $dados['onePublicacao']=0;
        $foot['onePublicacao']=0;
        
        $arr['autores'] =$this->modelusuarios->listar_autores();
        $dados['categorias']   =   $this->modelcategorias->listar_categorias();    

        
        $dados['titulo']    =   'Sobre Nos';
        $dados['subtitulo'] =   'Autores';
        $dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Sobre Nos';
        $arr['subtitulo'] =   'Autores';
        $arr['subtitulodb']   =  '';

        $arr['heardin']=$dados;
        $arr['footerurl'] = $foot;
        $this->template->load("template_frontend/main","sobrenos",$arr);
    }
    public function autor($id,$slug=null){
        $dados['onePublicacao']=0;
        $foot['onePublicacao']=0;
        $this->load->model("Modelcategorias","modelcategorias");
        $this->load->model("Modelusuarios","modelusuarios");
        $dados['categorias']   =   $this->modelcategorias->listar_categorias();
        $arr['autor'] =$this->modelusuarios->listar_autor($id);
       

        $dados['onePublicacao']=0;
        $foot['onePublicacao']=0;

        //Dados a serem enviados ao cabeçalho


        $dados['titulo']    =   'Autor';
        $dados['subtitulo'] =   $arr['autor'][0]['nome'];
        $dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Autor';
        $arr['subtitulo'] =   $arr['autor'][0]['nome'];
        $arr['subtitulodb']   =  '';


        $arr['footerurl'] = $foot;

        $arr['heardin']=$dados;
        $this->template->load("template_frontend/main","autor",$arr);
    }
}

/* End of file users.php */
/* Location: ./application/modules/home/controllers/Home.php */
