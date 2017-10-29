<!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Busca no Blog</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>
                <?php
                    if($onePublicacao != 1){
                        ?>
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Categorias do Blog</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                    <?php 
                                    foreach ($categorias as $categoria) {
                                    ?>
                                        <li><a href="<?php echo base_url('/categoria/'.limpar($categoria['name']).'/'.$categoria['id'] ); ?> "><?php echo $categoria['name']; ?></a></li>
                                    
                                    <?php
                                    }
                                    ?>
                                    
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <?php
                }

                if($onePublicacao==1){
                ?>
                <!-- Blog Categories da publicacao Well -->
                <div class="well">
                    <h4>Categorias da Publicação</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                if($publicacaoCategorias!=null){
                                    foreach ($publicacaoCategorias as $categoria) {
                                    ?>
                                        <li><?php echo $categoria; ?></li>
                                    <?php 

                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Blog Bibliotecas da publicacao Well -->
                <div class="well">
                    <h4>Bibliotecas da Publicação</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                if($publicacaoJs!=null){
                                    foreach ($publicacaoJs as $js) {
                                    ?>
                                        <li><?php echo $js; ?></li>
                                    <?php 

                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <?php 

                }
                ?>
