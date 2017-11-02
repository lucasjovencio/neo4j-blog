 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Administrar <?php echo $titulo;?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Alterar <?php echo $subtitulo; ?> Existente
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
                                            $this->table->set_heading("Foto","Titulo","Data","Alterar","Excluir");
                                        if($publicacoes !=null){
                                            foreach ($publicacoes as $publicacao) {
                                                
                                                if($publicacao['img']!='null'){
                                                    $image_properties = array(
                                                       'src' => $publicacao['img'],
                                                       'alt'   => '',
                                                       'width' => '240',
                                                       'heght' => '240'
                                                    );
                                                    $fotopub = img($image_properties);
                                                }
                                                else{
                                                    $image_properties = array(
                                                       'src' =>'http://placehold.it/900x300',
                                                       'width' => '240',
                                                       'heght' => '240'
                                                    );
                                                    $fotopub = img($image_properties);
                                                }
                                                $titulopub = $publicacao['titulo'];
                                                $datapub = '10/10/2017 às 21:30';//postadoem($publicacao->data);
                                                $alterar = anchor(base_url('admin/publicacao/alterar/'.md5($publicacao['id'])),'<i class="fa fa-refresh fa-fw"></i> Alterar');
                                                $excluir = anchor(base_url('admin/publicacao/excluir/'.md5($publicacao['id'])),'<i class="fa fa-remove fa-fw"></i> Excluir');

                                                $this->table->add_row($fotopub,$titulopub,$datapub,$alterar,$excluir);
                                            }
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
                <!-- /.col-lg-12 -->
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