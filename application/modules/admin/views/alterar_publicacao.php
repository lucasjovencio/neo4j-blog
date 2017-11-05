 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Alterar <?php echo $titulo;?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Alterar <?php echo $subtitulo; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                        echo validation_errors('<div class="alert alert-danger">','</div>');
                                        echo form_open_multipart('admin/atualisar_publicacao');
                                        echo form_hidden('id_img',md5(uniqid(time())));
                                        $imagem = array('name'=>'userfile','id'=>'userfile','class'=>'form-control img-responsive');
                                    ?>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Categorias do Artigo</label>
                                            <select multiple  id="select-cat[]" name="select-cat[]" class="form-control">
                                                
                                            <?php
                                                foreach ($categorias as $key){
                                                    ?>
                                                    <option <?php  echo $key['selecionado']; ?> value="<?php echo $key['name']; ?>"><?php echo $key['name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label>JavaScripts para o artigo</label>
                                            <select multiple  id="select-js[]" name="select-js[]" class="form-control">
                                                <?php 
                                                foreach($javascripts as $js){?>
                                                    <option <?php  echo $js['selecionado']; ?> value="<?php echo $js['name']; ?>"><?php echo $js['name']; ?></option>
                                                <?php } 
                                                ?>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Título</label>
                                            <input type="text" class="form-control" placeholder="Digite o título completo" id="txt-titulo" name="txt-titulo" value="<?php echo $single[0]['titulo']; ?>">
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label>Subtítulo</label>
                                            <input type="text" class="form-control" placeholder="Digite o Subtítulo" id="txt-subtitulo" name="txt-subtitulo" value="<?php echo $single[0]['subtitulo'];  ?>">
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label>Imagem de Cabeçalho</label>
                                                <style type="text/css">
                                                    img{
                                                        width: 200px;
                                                        margin-bottom: 10px;
                                                    }
                                                </style>
                                                <br>
                                                <?php
                                                    if($single[0]['img']!='null'){
                                                        echo img($single[0]['img']);
                                                    }
                                                    else{
                                                        echo img('/assets/frontend/img/usuarios/semFoto.png');
                                                    }
                                                ?>
                                            <?php echo form_upload($imagem); ?>
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label>Data</label>
                                            <input type="text" class="form-control" placeholder="Informe a data" id="txt-date" name="txt-date" value="<?php echo $single[0]['data'];  ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Conteudo</label>
                                        <textarea class="form-control" placeholder="Digite o Conteudo" id="txt-conteudo" name="txt-conteudo"><?php echo $single[0]['conteudo'];  ?></textarea> 
                                    </div>
                                    
                                    
                                    <input type="hidden" name="txt-id" id="txt-id" value="<?php echo($single[0]['id']); ?>">
                                    <input type="hidden" name="txt-id-user" id="txt-id-user" value="<?php echo($this->session->userdata('userlogado')); ?>">
                                    <button type="submit" class="btn btn-default">Atualisar</button>
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
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>