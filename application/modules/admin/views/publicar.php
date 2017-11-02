 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Adicionar <?php echo $titulo;?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Adicionar nova <?php echo $subtitulo; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                        echo validation_errors('<div class="alert alert-danger">','</div>');
                                        echo form_open_multipart('admin/inserir_publicacao');
                                        echo form_hidden('id_img',md5(uniqid(time())));
                                        $imagem = array('name'=>'userfile','id'=>'userfile','class'=>'form-control img-responsive');
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label>Categorias do Artigo</label>
                                        <select multiple  id="select-cat[]" name="select-cat[]" class="form-control">
                                            <?php foreach($categorias as $categoria){?>
                                                <option value="<?php echo $categoria['name']; ?>"><?php echo $categoria['name']; ?></option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label>JavaScripts para o artigo</label>
                                        <select multiple  id="select-js[]" name="select-js[]" class="form-control">
                                            <?php foreach($javascripts as $js){?>
                                                <option value="<?php echo $js['name']; ?>"><?php echo $js['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Título</label>
                                        <input type="text" class="form-control" placeholder="Digite o título completo" id="txt-titulo" name="txt-titulo" value="<?php echo set_value('txt-titulo'); ?>">
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label>Subtítulo</label>
                                        <input type="text" class="form-control" placeholder="Digite o Subtítulo" id="txt-subtitulo" name="txt-subtitulo" value="<?php echo set_value('txt-subtitulo');  ?>">
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label>Imagem de Cabeçalho</label>
                                        <?php echo form_upload($imagem); ?>
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label>Data</label>
                                        <input type="text" class="form-control" placeholder="Informe a data" id="txt-date" name="txt-date" value="<?php echo set_value('txt-date');  ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Conteudo</label>
                                        <textarea class="form-control" placeholder="Digite o Conteudo" id="txt-conteudo" name="txt-conteudo"><?php echo set_value('txt-conteudo');  ?></textarea> 
                                    </div>
                                    
                                    
                                    <input type="hidden" name="txt-id" id="txt-id" value="<?php echo($this->session->userdata('userlogado')); ?>">
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
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>