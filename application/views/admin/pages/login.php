<!-- data-lbg="teal" -->
<div class="login bg-color-dark-blue-6">
	<!-- Login -->
	<div class="l-block toggled" id="l-login">
		<!-- palette-Teal bg -->
		<div class="lb-header  bg-color-dark-red">
			<i class="zmdi zmdi-account-circle"></i>
			<strong>Hi there! Please Sign in</strong>
		</div>

		<div class="lb-body">
			<!-- Notification -->
			<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
			<?= form_open($form_new, ' autocomplete="off" id="" '); ?>
			<div class="form-group fg-float">
				<div class="fg-line">
					<input type="text" class="input-sm form-control fg-input" autocomplete="off" name="user_logname" value="<?= set_value('user_logname'); ?>">
					<label class="fg-label">Logname</label>
				</div>
				<span class="error"><?= form_error('user_logname') ?></span>
			</div>

			<div class="form-group fg-float">
				<div class="fg-line">
					<input type="password" class="input-sm form-control fg-input" autocomplete="new-password" name="user_password" value="<?= set_value('user_password'); ?>">
					<label class="fg-label">Password</label>
				</div>
				<span class="error"><?= form_error('user_password') ?></span>
			</div>

			<div class="form-group fg-float">
				<div class="checkbox m-b-15">
					<label>
						<input type="checkbox" value="yes" name="remember">
						<i class="input-helper"></i>
						<span class="color-red text">Keep me logged in</span>
					</label>
				</div>
			</div>

			<button type="submit" class="btn palette-Teal bg">Sign in</button>
			<?= form_close(); ?>
			<div class="m-t-20">
				<!--
                        <a data-block="#l-forget-password" data-bg="purple" href="#" class="palette-Purple text">Forgot password?</a>
                    -->
				<a class="palette-Teal text d-block m-b-5" href="<?= site_url(); ?>">Get me back to home page ...</a>
			</div>
		</div>
	</div>

	<!-- Forgot Password -->
	<div class="l-block" id="l-forget-password">
		<div class="lb-header palette-Purple bg">
			<i class="zmdi zmdi-account-circle"></i>
			Forgot Password?
		</div>

		<div class="lb-body">
			<p class="m-b-30">Did you forgot your password?</p>

			<div class="form-group fg-float">
				<div class="fg-line">
					<input type="text" class="input-sm form-control fg-input">
					<label class="fg-label">Sorry No Way Out</label>
				</div>
			</div>

			<button class="btn palette-Purple bg">Give</button>

			<div class="m-t-30">
				<a data-block="#l-login" data-bg="teal" class="palette-Purple text" href="#">Already have an account?</a>
				<a class="palette-Teal text d-block m-b-5" href="<?= site_url(); ?>">Get me back to home page ...</a>
			</div>
		</div>
	</div>
</div>
