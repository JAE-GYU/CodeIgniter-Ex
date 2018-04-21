<div id="login" class="bg-light">
	<div class="container py10">
		<div class="col-md-7 col-sm-10 col-center login-panel">
			<div class="col-12 col-center">
				<div class="col-9 col-center">
					<h1 class="title text-center text-black">Create Account</h1>
					<form action="/register" method="post">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
                        <div class="form-group">
                            <label for="name" class="text-black">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" value="<?php echo set_value('name')?>">
                            <?php echo form_error('name','<span class="mt-2 text-danger text-small">','</span>')?>
                        </div>
						<div class="form-group">
                            <label for="email" class="text-black">Email</label>
							<input type="email" id="email" name="email" class="form-control" placeholder="example@domain.com" value="<?php echo set_value('email')?>">
                            <?php echo form_error('email','<span class="mt-2 text-danger text-small">','</span>')?>
						</div>
						<div class="form-group">
                            <label for="password" class="text-black">Password</label>
							<input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            <?php echo form_error('password','<span class="mt-2 text-danger text-small">','</span>')?>
						</div>
                        <div class="form-group">
                            <label for="password_confirm" class="text-black">Password Confirm</label>
                            <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Password Confirm">
                            <?php echo form_error('password_confirm','<span class="mt-2 text-danger text-small">','</span>')?>
                        </div>
                        <button class="mt-3 mb-4 p-2 mb-1 btn btn-block btn-primary">Create Account</button>
					</form>
                    <div class="col-12 text-center">
                        <a href="/login" class="text-small font-300">Already have an account? / Sign In</a>
                    </div>
				</div>
			</div>			
		</div>
	</div>
</div>