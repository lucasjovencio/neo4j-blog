<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller{
	public function __construct(){
            parent::__construct();
            date_default_timezone_set('America/Sao_Paulo');
    }
    public function index(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        $dados['titulo']    =   'Painel de Administração';
        $dados['subtitulo'] =   '';
        $dados['subtitulodb']   =  '';
        $arr['titulo']    =   'Painel de Administração';
        $arr['subtitulo'] =   '';
        $arr['subtitulodb']   =  '';

        $arr['heardin']=$dados;
    	$this->template->load("template_backend/main","index",$arr);
    }
    public function categoria($publicado=null){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        else if($this->session->userdata('direito')==md5(0)){
            redirect(base_url('admin'));
        }
        //Dados a serem enviados ao cabeçalho
        $dados['titulo']    =   'Categoria';
        $dados['subtitulo'] =   'Categoria';


        $arr['titulo']      =   'Categoria';
        $arr['subtitulo']   =   'Categoria';
        $arr['publicado']   =   $publicado;
        $arr['heardin']     =   $dados;
        
        $this->load->library('table');

        $this->load->model("Modelcategorias","modelcategorias");
        $arr['categorias']   =   $this->modelcategorias->listar_categorias();

        $this->template->load("template_backend/main","categoria",$arr);
    }
    public function inserir_categoria(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        else if($this->session->userdata('direito')==md5(0)){
            redirect(base_url('admin'));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-categoria','Nome da Categoria','required|min_length[3]');
        if ($this->form_validation->run()==false){
            $this->categoria();
        }else{
            $titulo = $this->input->post("txt-categoria");
            $this->load->model("Modelcategorias","modelcategorias");
            if($this->modelcategorias->verifica_existencia_categoria($titulo)){
                $this->categoria("2");
            }else{
                if($this->modelcategorias->adicionar($titulo)){
                    $this->categoria();
                }
                else{
                    echo "Aconteceu um error no sistema.";
                }
                
            }
        }
    }
    public function alterar_categoria($name){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        else if($this->session->userdata('direito')==md5(0)){
            redirect(base_url('admin'));
        }
        $this->load->model("Modelcategorias","modelcategorias");


        $dados['titulo']    =   'Categoria';
        $dados['subtitulo'] =   $name;


        $arr['titulo']      =   'Categoria';
        $arr['subtitulo']   =   $name;
        $arr['heardin']     =   $dados;

        $this->load->library('table');

        $this->template->load("template_backend/main","alterar_categoria",$arr);
    }
    public function salvar_alteracoes_categoria(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        else if($this->session->userdata('direito')==md5(0)){
            redirect(base_url('admin'));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-categoria','Nome da Categoria','required|min_length[3]');
        if ($this->form_validation->run()==false){
            $this->categoria();
        }else{
            $this->load->model("Modelcategorias","modelcategorias");
            $titulo = $this->input->post("txt-categoria");
            $id     = $this->input->post("txt-id");
            if($this->modelcategorias->alterar($titulo,$id)){
                redirect(base_url('admin/categoria'));
            }else{
                echo("Houve um erro no sistema!");
            }
        }
    }
    public function excluir_categoria($id){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        else if($this->session->userdata('direito')==md5(0)){
            redirect(base_url('admin'));
        }

        $this->load->model("Modelcategorias","modelcategorias");
        if($this->modelcategorias->excluir($id)){
            redirect(base_url('admin/categoria'));
        }else{
            echo("Houve um erro no sistema!");
        }
    }
    public function publicacao($pular=null,$publicado=null){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }

        $this->load->model("Modelcategorias","modelcategorias");
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model('Modeljavascripts','modeljavascripts');
        if(!$pular){
            $pular=0;
        }

        /* Paginacao */
        $post_por_pagina = 5;//(null == $post_por_pagina) ? 2 : $post_por_pagina;
        $config['base_url']     = base_url("admin/publicacao");
        $config['total_rows']   = $this->modelpublicacao->contar();
        $config['per_page']     = $post_por_pagina;
        /* FIM */

        //Dados a serem enviados ao cabeçalho
        $dados['titulo']    =   'Publicações';
        $dados['subtitulo'] =   'Publicações';


        $arr['titulo']      =   'Publicações';
        $arr['subtitulo']   =   'Publicações';
        $arr['publicado']   =   $publicado;
        $arr['heardin']     =   $dados;


        $arr['publicacoes']   =   $this->modelpublicacao->listar_publicacao($pular,$post_por_pagina);

        $this->load->library('table');

        $this->load->helper('date');
        
        $this->load->library('pagination');
        
        $this->pagination->initialize($config);

        $arr['links_paginacao'] = $this->pagination->create_links();

        $arr['categorias']   =   $this->modelcategorias->listar_categorias();  
        $arr['javascripts']   =   $this->modeljavascripts->listar_javascripts();

        $this->template->load("template_backend/main","publicacoes",$arr);
    }
    public function publicar($publicado=null){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }

        $this->load->model("Modelcategorias","modelcategorias");
        $this->load->model('Modelpublicacoes','modelpublicacao');
        $this->load->model('Modeljavascripts','modeljavascripts');

        //Dados a serem enviados ao cabeçalho
        $dados['titulo']    =   'Publicação';
        $dados['subtitulo'] =   'Publicação';


        $arr['titulo']      =   'Publicação';
        $arr['subtitulo']   =   'Publicação';
        $arr['publicado']   =   $publicado;
        $arr['heardin']     =   $dados;


        $this->load->library('table');

        $this->load->helper('date');

        $arr['categorias']   =   $this->modelcategorias->listar_categorias();  
        $arr['javascripts']   =   $this->modeljavascripts->listar_javascripts();

        $this->template->load("template_backend/main","publicar",$arr);


    }
    public function inserir_publicacao(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-titulo','Título','required|min_length[3]');
        $this->form_validation->set_rules('txt-subtitulo','SubTítulo','required|min_length[3]');
        $this->form_validation->set_rules('txt-conteudo','Conteudo','required|min_length[25]');
        $this->form_validation->set_rules('txt-date','Data','required');
        $this->form_validation->set_rules('select-cat[]','Categoria','required');
        $this->form_validation->set_rules('select-js[]','JavaScript','required');
        $this->form_validation->set_rules('userfile','Imagem','trim|xss_clean');
        $id = $this->input->post('id_img');

        $config['upload_path'] = './assets/frontend/img/publicacao';
        $config['allowed_types']='jpg';
        $config['file_name']=$id.'.jpg';
        $config['overwrite']=TRUE;
        

        if ($this->form_validation->run()==false){
            $this->publicar();
        }else{

            $this->load->library('upload',$config);
            if(!$this->upload->do_upload()){
                echo $this->upload->display_errors();
            }else{
                $config2['image_library'] = 'gd2';
                $config2['source_image']    = './assets/frontend/img/publicacao/'.$id.'.jpg';
                $config2['create_thumb']    = FALSE;
                $config2['width']           = 900;

                $this->load->library('image_lib', $config2);

                if($this->image_lib->initialize($config2)){
                    $titulo = $this->input->post("txt-titulo");
                    $subtitulo = $this->input->post("txt-subtitulo");
                    $conteudo = $this->input->post("txt-conteudo");
                    $date = $this->input->post("txt-date");
                    $id = $this->input->post("txt-id");
                    $cat = $this->input->post("select-cat");
                    $js = $this->input->post("select-js");
                    $url = $config2['source_image'];
                    $this->load->model('Modelpublicacoes','modelpublicacao');
                    if($this->modelpublicacao->adicionar($titulo,$subtitulo,$conteudo,$date,$id,$cat,$url,$js)){
                        redirect(base_url('admin/publicar'));
                    }else{
                        echo("Houve um erro no sistema!");
                    }
                }
                else{
                    echo $this->image_lib->display_errors();
                }
            }
        }
    }
    public function usuarios($pular=null,$publicado=null){
        if(!$this->session->userdata('logado') ){
            redirect(base_url('admin/login'));
        }
        else if($this->session->userdata('direito')==md5(0)){
            redirect(base_url('admin'));
        }

        $this->load->model('Modelusuarios','modelusuarios');
        $this->load->library('table');
        $arr['usuarios'] = $this->modelusuarios->listar_autores();

        if(!$pular){
            $pular=0;
        }

        /* Paginacao */
        $post_por_pagina = 2;//(null == $post_por_pagina) ? 2 : $post_por_pagina;
        $config['base_url']     = base_url("admin/usuarios");
        $config['total_rows']   = $this->modelusuarios->contar();
        $config['per_page']     = $post_por_pagina;
        /* FIM */


        //Dados a serem enviados ao cabeçalho
        $dados['titulo']    =   'Painel de Usuário';
        $dados['subtitulo'] =   'Usuário';


        $arr['titulo']      =   'Painel de Usuário';
        $arr['subtitulo']   =   'Usuário';
        $arr['publicado']   =   $publicado;
        $arr['heardin']     =   $dados;

        
        $this->load->library('table');
        
        $this->load->library('pagination');
        
        $this->pagination->initialize($config);

        $arr['links_paginacao'] = $this->pagination->create_links();

        $this->template->load("template_backend/main","usuarios",$arr);
    }
    public function perfil(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }

        $this->load->model('Modelusuarios','modelusuarios');
        
        $arr['usuario'] = $this->modelusuarios->usuario_detalhes($this->session->userdata('userlogado'));
        $this->load->library('table');

        $this->load->helper('date');
        //Dados a serem enviados ao cabeçalho
        $dados['titulo']    =   $arr['usuario'][0]['nome'];
        $dados['subtitulo'] =   $arr['usuario'][0]['nome'];


        $arr['titulo']      =   $arr['usuario'][0]['nome'];
        $arr['subtitulo']   =   $arr['usuario'][0]['nome'];
        $arr['heardin']     =   $dados;

        $this->template->load("template_backend/main","perfil",$arr); 
    }

    public function inserir_usuario(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        else if($this->session->userdata('direito')==md5(0)){
            redirect(base_url('admin'));
        }
        $this->load->model('Modelusuarios','modelusuarios');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-nome','Nome do Usuario','required|min_length[3]');

        $this->form_validation->set_rules('txt-email','Email','required|valid_email');

        $this->form_validation->set_rules('txt-historico','Historico','required|min_length[20]');

        $this->form_validation->set_rules('txt-user','Username','required|min_length[3]');

        $this->form_validation->set_rules('txt-senha','Senha','required|min_length[3]');

        $this->form_validation->set_rules('txt-senha-2','Confirma Senha','required|min_length[3]|matches[txt-senha]');

        $id = $this->input->post('id_img');
        $config['upload_path'] = './assets/frontend/img/usuarios';
        $config['allowed_types']='jpg';
        $config['file_name']=$id.'.jpg';
        $config['overwrite']=TRUE;

        
        if ($this->form_validation->run()==false){
            $this->usuarios();
        }else{
            $this->load->library('upload',$config);
            if(!$this->upload->do_upload()){
                echo $this->upload->display_errors();
            }else{
                $nome = $this->input->post("txt-nome");
                $email = $this->input->post("txt-email");
                $historico = $this->input->post("txt-historico");
                $user = $this->input->post("txt-user");
                $senha = $this->input->post("txt-senha");
                $img = 'assets/frontend/img/usuarios/'.$id.'.jpg';
                if($this->modelusuarios->adicionar($nome,$email,$historico,$user,$senha,$img)){
                    $this->usuarios();
                }else{
                    echo("Houve um erro no sistema!");
                }
            }
            
            
        }
    }
    public function alterar_usuario($id){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }

        $this->load->model('Modelusuarios','modelusuarios');
        
        $arr['usuario'] = $this->modelusuarios->usuario_detalhes($id);
        $this->load->library('table');

        $this->load->helper('date');
        //Dados a serem enviados ao cabeçalho
        $dados['titulo']    =   'Painel de Usuário';
        $dados['subtitulo'] =   'Alterar Usuário';


        $arr['titulo']      =   'Painel de Usuário';
        $arr['subtitulo']   =   'Alterar Usuário';
        $arr['heardin']     =   $dados;

        $this->template->load("template_backend/main","alterar_usuario",$arr);
    }
    public function desativar_usuario($id){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        $this->load->model('Modelusuarios','modelusuarios');

        if($this->modelusuarios->desativar($id)){
            $this->usuarios();
        }else{
            echo("Houve um erro no sistema!");
        }
    }
    public function ativar_usuario($id){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        $this->load->model('Modelusuarios','modelusuarios');

        if($this->modelusuarios->ativar($id)){
            $this->usuarios();
        }else{
            echo("Houve um erro no sistema!");
        }
    }

    public function salvar_alteracoes_usuario(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }

        $this->load->model('Modelusuarios','modelusuarios');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('txt-nome','Nome do Usuário', 'required|min_length[3]');
         

        $this->form_validation->set_rules('txt-email','Email','required|valid_email');

        $this->form_validation->set_rules('txt-historico','Historico','required|min_length[20]');

        $this->form_validation->set_rules('txt-senha','Senha','required|min_length[3]');

        $this->form_validation->set_rules('txt-senha-2','Confirma Senha','required|min_length[3]|matches[txt-senha]');



        if ($this->form_validation->run()==false){
            $this->alterar_usuario($this->input->post("txt-id"));
        }else{
            $id_img = $this->input->post('id_img');
            $config['upload_path'] = './assets/frontend/img/usuarios';
            $config['allowed_types']='jpg';
            $config['file_name']=$id_img.'.jpg';
            $config['overwrite']=TRUE;

            $this->load->library('upload',$config);
            if(!$this->upload->do_upload()){
                echo $this->upload->display_errors();
            }else{
                $nome = $this->input->post("txt-nome");
                $email = $this->input->post("txt-email");
                $historico = $this->input->post("txt-historico");
                $senha = $this->input->post("txt-senha");
                $id = $this->input->post("txt-id");
                
                $img = 'assets/frontend/img/usuarios/'.$id_img.'.jpg';
                if($this->modelusuarios->alterar($nome,$email,$historico,$id,$senha,$img)){
                    $this->alterar_usuario($this->input->post("txt-id"));
                }else{
                    echo("Houve um erro no sistema!");
                }
            }
        }
    }
    public function salvar_alteracoes_perfil(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }

        $this->load->model('Modelusuarios','modelusuarios');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('txt-nome','Nome do Usuário', 'required|min_length[3]');
         

        $this->form_validation->set_rules('txt-email','Email','required|valid_email');

        $this->form_validation->set_rules('txt-historico','Historico','required|min_length[20]');

        $this->form_validation->set_rules('txt-senha','Senha','required|min_length[3]');

        $this->form_validation->set_rules('txt-senha-2','Confirma Senha','required|min_length[3]|matches[txt-senha]');

        if ($this->form_validation->run()==false){
            $this->perfil($this->input->post("txt-id"));
        }else{
            $id_img = $this->input->post('id_img');
            $config['upload_path'] = './assets/frontend/img/usuarios';
            $config['allowed_types']='jpg';
            $config['file_name']=$id_img.'.jpg';
            $config['overwrite']=TRUE;
            $this->load->library('upload',$config);
            if(!$this->upload->do_upload()){
                echo $this->upload->display_errors();
            }else{
                $nome = $this->input->post("txt-nome");
                $email = $this->input->post("txt-email");
                $historico = $this->input->post("txt-historico");
                $senha = $this->input->post("txt-senha");
                $id = $this->input->post("txt-id");
                $img = 'assets/frontend/img/usuarios/'.$id_img.'.jpg';
                if($this->modelusuarios->alterar($nome,$email,$historico,$id,$senha,$img)){
                    redirect(base_url('admin/perfil'));
                }else{
                    echo("Houve um erro no sistema!");
                }
            }
        }
    }
    public function pag_login(){
        //Dados a serem enviados ao cabeçalho
        $dados['titulo']    =   'Painel de Controle';
        $dados['subtitulo'] =   'Entrar no sistema';
        $dados['valida']    =   1;
        $arr['titulo']      =   'Painel de Controle';
        $arr['subtitulo']   =   'Entrar no sistema';
        $arr['heardin']     =   $dados;

        $this->template->load("template_backend/main_login","login",$arr);
    }

    public function login_check(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt-user','Nome do Usuario','required|min_length[3]');
        $this->form_validation->set_rules('txt-senha','Senha do Usuario','required|min_length[3]');
        if ($this->form_validation->run()==false){
            $this->pag_login();
        }else{

            $usuario    = $this->input->post('txt-user');
            $senha      = $this->input->post('txt-senha');
            $this->load->model('Modelusuarios','modelusuarios');
            $userlogado = $this->modelusuarios->verificar_login($usuario,$senha);
            if(intval($userlogado[0]['result'])){
                $dadosSessao['userlogado']=$userlogado[0]['user'];
                $dadosSessao['direito']= md5(intval($userlogado[0]['direito']));
                $dadosSessao['logado']=TRUE;
                $this->session->set_userdata($dadosSessao);
                redirect(base_url('admin'));
            }else{
                $dadosSessao['userlogado']=NULL;
                $dadosSessao['logado']=FALSE;
                $this->session->set_userdata($dadosSessao);
                redirect(base_url('admin/login'));
            }
        }
    }

    public function logout(){
        if(!$this->session->userdata('logado')){
            redirect(base_url('admin/login'));
        }
        $dadosSessao= NULL;
        $this->session->set_userdata($dadosSessao);
        redirect(base_url('admin/login'));
    }
}

/* End of file users.php */
/* Location: ./application/modules/home/controllers/Home.php */
