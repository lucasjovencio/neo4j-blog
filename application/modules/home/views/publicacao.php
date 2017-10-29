    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                
                <h2>
                    <?php echo $publicacao[0]['titulo']; ?>
                </h2>
                <p class="lead">
                    por <a href="<?php echo base_url('autor/'.$publicacao[0]['id_autor'].'/'.limpar($publicacao[0]['nome_autor'])); ?>"><?php echo $publicacao[0]['nome_autor']; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo postadoem($publicacao[0]['data']); ?> </p>
                <hr>
                <?php
                    if($publicacao[0]['img'] != 'null'){
                        $image_properties = array(
                           'src' => $publicacao[0]['img'],
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
                    <?php echo $publicacao[0]['subtitulo']; ?>
                </p>
                <p>
                    <?php echo $publicacao[0]['conteudo']; ?>
                </p>

                <hr>
                
                
            </div>