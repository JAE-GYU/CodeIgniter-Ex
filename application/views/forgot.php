<div id="login" class="bg-light">
	<div class="container py10">
		<div class="col-md-7 col-sm-10 col-center login-panel">
			<div class="col-12 col-center">
				<div class="col-9 col-center">
					<h1 class="title text-center text-black">Forgot Password</h1>
					<?php if(!isset($email_value)) { ?>
                    <form action="/forgot" method="post">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
						<div class="form-group">
                            <label for="email" class="text-black">Email</label>
							<input type="email" id="email" name="email" class="form-control" placeholder="example@domain.com" value="<?php echo set_value('email')?>">
                            <?php echo form_error('email','<span class="mt-2 text-danger text-small">','</span>')?>
						</div>						
                        <button class="mt-3 mb-4 p-2 mb-1 btn btn-block btn-primary">Send Email</button>
                    </form>
                    <?php }else {?>
                    <div class="col-12 text-center font-weight-100">
                    	<span class="font-300">Send email to <span class="font-semibold"><?php echo $email_value ?></span></span>
                    	<div class="col-12 text-center mt-3">
                        	<a href="/login" class="text-small font-300">Back to Sign In</a>
                    	</div>
                    </div>						
                    <?php }?>                    
				</div>
			</div>			
		</div>
	</div>
</div>