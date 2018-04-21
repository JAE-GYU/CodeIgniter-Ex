<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>CodeIgniter Ex</title>
	<link rel="stylesheet" href="/assets/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/fonts.css">
	<link rel="stylesheet" href="/assets/css/css.css">
	<link rel="stylesheet" href="/assets/css/fontawesome-all.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/assets/js/popper.min.js"></script>
	<script src="/assets/bootstrap/bootstrap.min.js"></script>
</head>
<body>
	<header>
		<nav class="navbar navbar-white navbar-expand-lg navbar-light">
			<div class="container">
				<a class="navbar-brand" href="/">CodeIgniter Ex</a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>

				  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				    <ul class="navbar-nav mr-auto">
				      <li class="nav-item active">
				        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
				      </li>
				      <li class="nav-item active">
				        <a class="nav-link" href="/upload">Upload <span class="sr-only">(current)</span></a>
				      </li>		      
				    </ul>
				    <ul class="navbar-nav ml-auto">
                        <?php if($this->session->userdata('login')) { ?>
                            <li class="nav-item">
                                <a href="#" class="font-semibold nav-link nav-item"><?php echo $this->session->userdata('login')->name?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/logout" class="nav-link nav-item">Logout</a>
                            </li>
                        <?php }else {?>
                            <li class="nav-item">
                                <a href="/login" class="nav-link nav-item">Sign In</a>
                            </li>
                        <?php }?>
				    </ul>
				  </div>	
			</div>		  
		</nav>
        <?php if($this->session->flashdata('msg')) {?>
            <div class="alert alert-<?php echo $this->session->flashdata('msg')['status']?> alert-dismissible fade show" role="alert">
                <div class="container">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong><?php echo $this->session->flashdata('msg')['title']?></strong> <?php echo $this->session->flashdata('msg')['text']?>
                </div>
            </div>
        <?php }?>
	</header>