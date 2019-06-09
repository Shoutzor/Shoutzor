{% block content %}
<style type="text/css">
#nowplaying_bg {
	width: 100%;
	height: 100%;
	overflow: hidden;
	position: absolute;
	left: 0;
	top: 0;
	z-index: -9999;
  border-radius: 3px;
  box-shadow: 0 0 1px #000;
  background-repeat: no-repeat, repeat;
  background-size: cover, 188px 187px;
  background-position: 0 35%, 0px 0px;
  background-blend-mode: saturation;
  background-image: url('/assets/images/album_temp_bg.jpg'), url('/assets/images/nowplaying_overlay.png');
}

#nowplaying {
  background: transparent;
  border: 0;
  box-shadow: none;
  margin-top: 1.5rem;
}

#nowplaying-album-image {
  min-width:200px;
  max-width:200px;
  min-height: 200px;
  max-height: 200px;
  box-shadow: 0 0 2px #000;
}

#nowplaying-info {
  padding-bottom: 0;
  color: #FFF !important;
  text-shadow: 0 0 4px #000;
}
</style>

<div class="container">
	<div class="row row-cards my-md-3">
		<div class="col-sm-12">
      <div id="nowplaying_bg"></div>
			<div id="nowplaying" class="card card-aside">
				<img id="nowplaying-album-image" class="card-aside-column" src="/assets/images/album_temp.jpg" alt="album image" />
				<div id="nowplaying-info" class="card-body d-flex flex-column mt-auto">
					<h3 style="font-size:20px;margin-bottom:1px;">Ghosts &apos;n stuff</h3>
					<p style="font-size:18px;">Deadmau5</p>
					<div><small class="text-muted">Requested by</small></div>
					<div>Someone</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row row-cards row-deck">
		<div class="col-12">
			<div class="card">
				<div class="table-responsive">
					<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
						<thead>
							<tr>
								<th class="text-center w-1"></th>
								<th>Song</th>
								<th>Requested by</th>
								<th>Duration</th>
								<th>Est. Time played</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="5" class="bg-light">
									<div class="small text-muted">Coming up</div>
								</td>
							</tr>
							<tr>
								<td colspan="5">
										<div class="w-1 loader"></div>
								</td>
							</tr>

						<tr>
							<td class="text-center">
								<span class="stamp stamp-md bg-blue mr-3">
									<i class="fa fa-music"></i>
								</span>
							</td>
							<td>
								<div>Never gonna give you up</div>
								<div class="small text-muted">
									Rick Astley
								</div>
							</td>
							<td>
								<div>John Lee</div>
							</td>
							<td>
								<div>3:33</div>
							</td>
							<td>
								<div>15:07</div>
							</td>
						</tr>
						<tr>
							<td class="text-center">
								<span class="stamp stamp-md bg-green mr-3">
									<i class="fa fa-spotify"></i>
								</span>
							</td>
							<td>
								<div>Livin la vida loca</div>
								<div class="small text-muted">
									Eddie Murphy, Antonio Banderas
								</div>
							</td>
							<td>
								<div>Bobby Knight</div>
							</td>
							<td>
								<div>3:24</div>
							</td>
							<td>
								<div>15:11</div>
							</td>
						</tr>
						<tr>
							<td class="text-center">
								<span class="stamp stamp-md bg-red mr-3">
									<i class="fa fa-youtube-play"></i>
								</span>
							</td>
							<td>
								<div>Sweet but Psycho</div>
								<div class="small text-muted">
									Ava Max
								</div>
							</td>
							<td>
								<div>John Lee</div>
							</td>
							<td>
								<div>3:07</div>
							</td>
							<td>
								<div>15:14</div>
							</td>
						</tr>
						<tr>
							<td class="text-center">
								<span class="stamp stamp-md bg-orange mr-3">
									<i class="fa fa-soundcloud"></i>
								</span>
							</td>
							<td>
								<div>Sweet but Psycho</div>
								<div class="small text-muted">
									Ava Max
								</div>
							</td>
							<td>
								<div>John Lee</div>
							</td>
							<td>
								<div>3:07</div>
							</td>
							<td>
								<div>15:14</div>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{% endblock %}
