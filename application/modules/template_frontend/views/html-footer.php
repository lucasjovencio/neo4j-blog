    <!-- jQuery -->
    <script src="<?php echo base_url('assets/frontend/js/jquery.js'); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/frontend/js/bootstrap.min.js'); ?>"></script>
    <?php
    if($onePublicacao==1){
    	foreach ($js as $key){
    		?>
    			<script src="<?php echo base_url($key); ?>"></script>
    		<?php
    	}
    }
    ?>
</body>

</html>