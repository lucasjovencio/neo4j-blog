<?php 

	$this->load->view('template_backend/html-header',$heardin);
	$this->load->view('template_backend/template');
	echo $contents;
	
	$this->load->view('template_backend/html-footer');
?>
