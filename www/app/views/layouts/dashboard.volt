<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-3 ml-auto">
				<form class="input-icon my-3 my-lg-0">
					<input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
					<div class="input-icon-addon">
						<i class="fe fe-search"></i>
					</div>
				</form>
			</div>
			<div class="col-lg order-lg-first">
				<ul class="nav nav-tabs border-0 flex-column flex-lg-row">
					<li class="nav-item">
						<a href="/" class="nav-link active"><i class="fe fe-home"></i> Dashboard</a>
					</li>
          <li class="nav-item">
						<a href="/uploadmanager" class="nav-link"><i class="fe fe-upload"></i> Upload Manager</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="my-3 my-md-5" style="margin-top: 0 !important;">
		<?php echo $this->getContent(); ?>
</div>
