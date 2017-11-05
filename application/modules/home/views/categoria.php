    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    <?php echo $titulo; ?> -
                    <small><?php echo $subtitulo; ?></small>
                </h1>
                <?php 
                    if($publicacoes !=null){
                    foreach ($publicacoes as $publicacao) {
                ?>
                        <h2>
                            <a href=""> <?php echo $publicacao['titulo']; ?></a>
                        </h2>
                        <p class="lead">
                            por <a href=""><?php echo $publicacao['autor']; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo postadoem($publicacao['data']); ?> </p>
                        <hr>
                        <?php
                            if($publicacao['img']!='null'){
                                $image_properties = array(
                                   'src' =>$publicacao['img'],
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
                            <?php echo $publicacao['subtitulo']; ?>
                        </p>
                        <a class="btn btn-primary" href="<?php echo base_url("/publicacao/".$publicacao['id'].'/'.limpar($publicacao['titulo']))?>">Leia mais <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                <?php
                    }
                    echo "<div class='paginacao'>".$links_paginacao."</div>";
                }
                ?>

            </div>