<div id="login" class="bg-light">
	<div class="container py10">
		<div class="col-md-7 col-sm-10 col-center login-panel">
			<div class="col-12 col-center">
				<div class="col-9 col-center">
					<h1 class="title text-center text-black">Sign In</h1>
                    <form action="/login" method="post">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
						<div class="form-group">
                            <label for="email" class="text-black">Email</label>
							<input type="email" id="email" name="email" class="form-control" placeholder="example@domain.com" value="<?php echo set_value('email')?>">
                            <?php echo form_error('email','<span class="mt-2 text-danger text-small">','</span>')?>
						</div>
						<div class="form-group">
                            <label for="password" class="text-black">Password</label>
                            <a href="forgot" class="text-small text-grey float-right font-300"><u>Forgot?</u></a>
							<input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            <?php echo form_error('password','<span class="mt-2 text-danger text-small">','</span>')?>
						</div>
						<div class="custom-control custom-checkbox">
						  <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
						  <label class="custom-control-label text-grey font-300" for="customCheck1">Remember me</label>
						</div>
                        <button class="mt-3 mb-4 p-2 mb-1 btn btn-block btn-primary">Sign In</button>

                    <div class="col-12 text-center font-300">
                        <a href="/register" class="text-small">Don't have an account? / Create Account</a>
                    </div>
                    </form>
				</div>
			</div>			
		</div>
	</div>
</div>