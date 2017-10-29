<?php 

	$this->load->view('template_frontend/html-header',$heardin);
	$this->load->view('template_frontend/header');
	
	echo $contents;
	
	$this->load->view('template_frontend/aside');
	$this->load->view('template_frontend/footer');
	$this->load->view('template_frontend/html-footer',$footerurl);
?>
