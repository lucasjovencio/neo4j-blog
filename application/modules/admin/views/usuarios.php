 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Administrar <?php echo $titulo;?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Adicionar novo <?php echo $subtitulo; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                        echo validation_errors('<div class="alert alert-danger">','</div>');

                                        echo form_open_multipart('admin/inserir_usuario');
                                        echo form_hidden('id_img',md5(uniqid(time())));
                                        $imagem = array('name'=>'userfile','id'=>'userfile','class'=>'form-control img-responsive');
                                    ?>
                                    <div class="form-group">
                                        <label>Nome do Usuário</label>
                                        <input type="texto" class="form-control" placeholder="Digite o nome completo" id="txt-nome" name="txt-nome" value="<?php echo set_value('txt-nome'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Digite o email" id="txt-email" name="txt-email" value="<?php echo set_value('txt-email');  ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Historico</label>
                                        <textarea class="form-control" placeholder="Digite o Conteudo" id="txt-historico" name="txt-historico"><?php echo set_value('txt-historico');  ?></textarea> 
                                    </div>
                                    <div class="form-group">
                                        <label>User</label>
                                        <input type="texto" class="form-control" placeholder="Digite o nome de Usuário" id="txt-user" name="txt-user" value="<?php echo set_value('txt-user');  ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Imagem de Perfil</label>
                                        <?php echo form_upload($imagem); ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" class="form-control" placeholder="Digite a Senha" id="txt-senha" name="txt-senha" >
                                    </div>

                                    <div class="form-group">
                                        <label>Confirme a Senha</label>
                                        <input type="password" class="form-control" placeholder="Digite a Senha" id="txt-senha" name="txt-senha-2">
                                    </div>

                                    <button type="submit" class="btn btn-default">Cadastrar</button>
                                    <?php
                                        echo form_close();
                                    ?>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Alterar <?php echo $subtitulo; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                        <style>
                                            img{
                                                width: 60px;
                                            }
                                        </style>
                                        <?php
                                            $this->table->set_heading("Foto","Nome do Usuário","Alterar","Excluir");

                                            foreach ($usuarios as $usuario) {
                                                if($usuario['img']!='null'){
                                                    $fotouser = img($usuario['img']);
                                                }
                                                else{
                                                    $fotouser = img('/assets/frontend/img/usuarios/semFoto.png');
                                                }
                                                $nomeuser = $usuario['nome'];
                                                $alterar = anchor(base_url('admin/alterar_usuario/'.$usuario['id']),'<i class="fa fa-refresh fa-fw"></i> Alterar');
                                                $excluir = anchor(base_url('admin/excluir_usuario'.md5($usuario['id'])),'<i class="fa fa-remove fa-fw"></i> Excluir');

                                                $this->table->add_row($fotouser,$nomeuser,$alterar,$excluir);
                                            }
                                            $this->table->set_template(array(
                                                'table_open' => '<table class="table table-striped">'
                                                ));
                                            echo $this->table->generate();
                                            echo "<div class='paginacao'>".$links_paginacao."</div>";
                                        ?>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!--

    <form role="form">
                                        <div class="form-group">
                                            <label>Titulo</label>
                                            <input class="form-control" placeholder="Entre com o texto">
                                        </div>
                                        <div class="form-group">
                                            <label>Foto Destaque</label>
                                            <input type="file">
                                        </div>
                                        <div class="form-group">
                                            <label>Conteúdo</label>
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>Selects</label>
                                            <select class="form-control">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-default">Cadastrar</button>
                                        <button type="reset" class="btn btn-default">Limpar</button>
                                    </form>

                                    -->