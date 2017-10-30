    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    <?php echo $titulo; ?> -
                    <small>
                        <?php if($subtitulo != ''){
                            echo $subtitulo;
                        }?>
                    </small>
                </h1>
                
                  <div class="col-md-4">
                    <?php
                        if($autor[0]['img'] != 'null'){
                            $fotouser = $autor['img'];
                        }
                        else{
                            $fotouser = '/assets/frontend/img/usuarios/semFoto.png';
                        }
                        ?>
                        
                    <img class="img-responsive img-circle" src="<?php echo base_url($fotouser); ?>" alt="">
                    </div>
                    <div class="col-md-8 ">
                        <h2>
                           <?php echo $autor[0]['nome']; ?>
                        </h2> 
                        <hr>
                        <p>
                            <?php echo $autor[0]['historico']; ?>
                        </p>


                        <hr>
                    </div>
                
                
            </div>