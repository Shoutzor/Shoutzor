{% block content %}
<style type="text/css">
.fab {
  font-size: 22px;
  line-height: 1.9;
  font-weight: 300;
}

.upvote, .downvote {
  font-size: 20px;
  color: #FFF;
}

#nowplaying {
  position: relative;
  width: 100%;
  height: 250px;
}

#nowplaying_bg {
	width: 100%;
	height: 100%;
	overflow: hidden;
	position: absolute;
  left: 0;
	z-index: -9999;
  border-radius: 3px;
  box-shadow: 0 0 1px #000;
}

#nowplaying_bg_image {
  position: absolute;
  min-width: 100%;
  top: -115%;
}

#nowplaying_overlay {
  position: absolute;
  width: 100%;
  height: 100%;
  background-repeat: repeat;
  background-position: 0px 0px;
  background-image: url('/assets/images/nowplaying_overlay.png');
}

#nowplaying_content {
  position: absolute;
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

#nowplaying_requestedby {
  border-left: 1px solid #FFF;
}
</style>

<div class="container">

	<div class="row row-cards my-md-3">
    {% include 'parts/nowplaying.volt' %}
	</div>

  {{ flash.output() }}

	<div class="row row-cards row-deck">
		<div class="col-12">
			<div class="card">
				<div class="table-responsive">
          {% include 'parts/comingup.volt' %}
				</div>
			</div>
		</div>
	</div>
</div>
{% endblock %}
