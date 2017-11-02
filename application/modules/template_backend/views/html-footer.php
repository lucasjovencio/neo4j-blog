


    <!-- jQuery 
    <script src="<?php //echo base_url('assets/backend/js/jquery.min.js'); ?>"></script>
	-->
    <!-- Bootstrap Core JavaScript 
    <script src="<?php //echo base_url('assets/backend/js/bootstrap.min.js'); ?>"></script>
	-->

    <!-- Custom Theme JavaScript
    <script src="<?php //echo base_url('assets/backend/js/sb-admin-2.js'); ?>"></script>

     -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://demos.codexworld.com/includes/js/bootstrap.js"></script>
    <!-- tinymce -->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    
    <script type="text/javascript">
        tinymce.init({
          selector: '#txt-historico',
          height: 200,
          theme: 'modern',
          plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
          toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
          image_advtab: true,
          templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
          ],
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
          ]
         });    

         </script>
        <?php 
          $metodo = $this->uri->segment(2);
          if($metodo === 'publicar'){
        ?>
            <script type="text/javascript">
              tinymce.init({
                selector: '#txt-conteudo',
                height: 500,
                theme: 'modern',
                plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
                image_advtab: true,
                templates: [
                  { title: 'Test template 1', content: 'Test 1' },
                  { title: 'Test template 2', content: 'Test 2' }
                ],
                content_css: [
                  '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                  '//www.tinymce.com/css/codepen.min.css'
                ]
               });    

             </script>
            <script src="<?php echo base_url()?>assets/js/datetimepicker/jquery.js"></script>
            <script src="<?php echo base_url()?>assets/js/datetimepicker/build/jquery.datetimepicker.full.js"></script>
            <script>
                  $.datetimepicker.setLocale('pt-br');

                  $('.some_class').datetimepicker();

                  $('#txt-date').datetimepicker({
                    language: 'pt-BR',
                    formatTime:'H:i:s',
                    formatDate:'d.m.Y',
                    step:10,
                    timepickerScrollbar:true
                  });
                  $.datetimepicker.setLocale('pt-BR');
            </script>
        <?php 
          }
        ?>
</body>

</html>