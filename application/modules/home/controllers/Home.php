<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller{
	public function __construct(){
            parent::__construct();
            date_default_timezone_set('America/Sao_Paulo');
    }
    public function index($pular=null,$post_por_pagina=null){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");
        $dados['categorias']   =   $this->modelcategorias->listar_categorias();        

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

        $arr['publicacoes']   =   $this->modelpublicacao->listar_publicacao($pular,$post_por_pagina);
    


        $this->template->load("template_frontend/main","index",$arr);
    }
    public function publicacao($id,$slug){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");
        $dados['categorias']    =   $this->modelcategorias->listar_categorias();
        $arr['publicacao']      =   $this->modelpublicacao->single_publicacao($id);

        //Dados a serem enviados ao cabeçalho


        $dados['titulo']    =   'Publicação';
        $dados['subtitulo'] =   $arr['publicacao'][0]['titulo'];
        $dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Publicação';
        $arr['subtitulo'] =   $arr['publicacao'][0]['titulo'];
        $arr['subtitulodb']   =  '';

        $arr['heardin']=$dados;
        $this->template->load("template_frontend/main","publicacao",$arr);

    }
    public function categoria($slug,$id,$pular=null,$post_por_pagina=null){
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model("Modelcategorias","modelcategorias");
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

        $this->template->load("template_frontend/main","categoria",$arr);
    }
    public function sobrenos(){
        $this->load->model("Modelusuarios","modelusuarios");
        $this->load->model("Modelcategorias","modelcategorias");
        $arr['autores'] =$this->modelusuarios->listar_autores();
        $dados['categorias']   =   $this->modelcategorias->listar_categorias();    

        
        $dados['titulo']    =   'Sobre Nos';
        $dados['subtitulo'] =   'Autores';
        $dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Sobre Nos';
        $arr['subtitulo'] =   'Autores';
        $arr['subtitulodb']   =  '';

        $arr['heardin']=$dados;

        $this->template->load("template_frontend/main","sobrenos",$arr);
    }
}

/* End of file users.php */
/* Location: ./application/modules/home/controllers/Home.php */
