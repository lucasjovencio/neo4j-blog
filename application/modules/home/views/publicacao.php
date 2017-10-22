    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php 
                    foreach ($publicacao as $key) {
                ?>
                        <h2>
                            <?php echo $key['titulo']; ?>
                        </h2>
                        <p class="lead">
                            por <a href="<?php echo base_url('autor/'.$key['id_autor'].'/'.limpar($key['nome_autor'])); ?>"><?php echo $key['nome_autor']; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo postadoem($key['data']); ?> </p>
                        <hr>
                        <?php
                            if($key['img'] != 'null'){
                                $image_properties = array(
                                   'src' => $key['img'],
                                   'class' => 'img-responsive'
                                );  
                                echo img($image_properties);
                            }
                            else{
                                $image_properties = array(
                                   'src' =>'http://placehold.it/900x300',
                                   'class' => 'img-responsive'
                                );
                                echo img($image_properties);
                            }
                        ?>
                        <hr>
                        <p>
                            <?php echo $key['subtitulo']; ?>
                        </p>
                        <p>
                            <?php echo $key['conteudo']; ?>
                        </p>

                        <hr>
                <?php
                    }
                ?>
                
            </div>