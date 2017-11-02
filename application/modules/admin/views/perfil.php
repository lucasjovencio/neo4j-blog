  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Perfil <?php echo $titulo;?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Atualizar perfil: <?php echo $subtitulo; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <style>
                                            img{
                                                width: 240px;
                                            }
                                        </style>
                                    <?php
                                    foreach ($usuario as $key) {
                                        echo form_open_multipart('admin/salvar_alteracoes_perfil');
                                        echo form_hidden('id_img',md5(uniqid(time())));
                                        $imagem = array('name'=>'userfile','id'=>'userfile','class'=>'form-control img-responsive');
                                        echo validation_errors('<div class="alert alert-danger">','</div>');
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label>Nome do Usuário</label>
                                        <input type="texto" class="form-control" placeholder="Digite o nome completo" id="txt-nome" name="txt-nome" value="<?php echo $key['nome']; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Digite o email" id="txt-email" name="txt-email" value="<?php echo $key['email'];  ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Senha</label>
                                        <input type="password" class="form-control" placeholder="Digite a Senha" id="txt-senha" name="txt-senha" >
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Confirme a Senha</label>
                                        <input type="password" class="form-control" placeholder="Digite a Senha" id="txt-senha" name="txt-senha-2">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Historico</label>
                                        <textarea class="form-control" placeholder="Digite o Conteudo" id="txt-historico" name="txt-historico"><?php echo $key['historico'];  ?></textarea> 
                                    </div>
                                    
                                    <div class="form-group col-md-6">

                                        <label>Imagem de Perfil</label>
                                        <div class="col-lg-3 col-lg-offset-3">
                                            <?php
                                                if($key['img']!='null'){
                                                    echo img($key['img']);
                                                }
                                                else{
                                                    echo img('/assets/frontend/img/usuarios/semFoto.png');
                                                }
                                            ?>
                                        </div>
                                        <?php echo form_upload($imagem); ?>
                                    </div>
                                    

                                    <input type="hidden" name="txt-id" value="<?php echo $key['id'];  ?>">

                                    <button type="submit" class="btn btn-default">Atualizar</button>
                                    <?php
                                        
                                        echo form_close();
                                        }
                                    ?>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
