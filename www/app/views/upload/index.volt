<div class="container">

  {{ flash.output() }}

	<div class="row row-cards row-deck my-md-3">
		<div class="col-12">

      <div class="upload-rules alert alert-danger"><strong>Warning!</strong> Do NOT upload 18+ content or other harmful content, this will NOT be tolerated.</div>
      <div class="upload-rules alert alert-info"><strong>Notice</strong> The maximum file size is <?= $maxFileSize; ?></div>
      <div class="upload-rules alert alert-info"><strong>Notice</strong> The media duration limit is <?= $maxDuration; ?> minutes</div>

      <div id="upload-drop" class="uk-placeholder uk-placeholder-large uk-text-center">
          <i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i> Drop your file(s) here or <a class="uk-form-file">Select a file<input id="upload-select" type="file"></a>
      </div>

      <div id="progressbar" class="progress d-none">
          <div class="progress-bar" style="width: 0%;">...</div>
      </div>

      <div id="not-allowed" class="alert alert-danger d-none"><strong>Not allowed!</strong> Allowed filetypes are: wav, mp3, oga, flac, m4a &amp; wma</div>
      <div id="upload-error" class="alert alert-danger d-none"><strong>Error!</strong> One or more files failed to upload, please try again.</div>

      <div class="uk-panel uk-panel-box">
          <div class="uk-panel-title">
              <p>Upload progress</p>
          </div>

          <ul id="uploadList" class="uk-list uk-list-line">
              <?php if(count($uploads) == 0): ?>
                  <li id="uploadListEmpty"><p>You have no remaining uploads (finished uploads will not show here)</p></li>
              <?php endif; ?>

              <?php foreach($uploads as $upload): ?>
                  <?= $view->render('views/parts/uploadmanager-item.volt', ['upload' => $upload]); ?>
              <?php endforeach; ?>
          </ul>
      </div>
    </div>
  </div>
</div>
