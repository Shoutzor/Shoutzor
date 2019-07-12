<?php
    use Xorinzor\Shoutzor\Model\Media;

    $status = array(
        Media::STATUS_UPLOADED => array(
            'label' => 'Waiting',
            'progressbar' => 'Waiting to be processed..',
            'labelclass' => 'uk-badge-warning',
            'progressbarclass' => 'uk-progress-warning uk-progress-striped uk-active'
        ),
        Media::STATUS_PROCESSING => array(
            'label' => 'Processing',
            'progressbar' => 'Processing..',
            'labelclass' => '',
            'progressbarclass' => 'uk-progress-striped uk-active'
        ),
        Media::STATUS_FINISHED => array(
            'label' => 'Finished',
            'progressbar' => 'Finished',
            'labelclass' => 'uk-badge-success',
            'progressbarclass' => 'uk-progress-success'
        ),
        Media::STATUS_ERROR => array(
            'label' => 'Error',
            'progressbar' => 'An error occurred while processing, please try again',
            'labelclass' => 'uk-badge-danger',
            'progressbarclass' => 'uk-progress-danger'
        ),
        Media::STATUS_DUPLICATE => array(
            'label' => 'Duplicate',
            'progressbar' => 'This song has already been uploaded',
            'labelclass' => 'uk-badge-danger',
            'progressbarclass' => 'uk-progress-danger'
        ),
        Media::STATUS_DURATION_TOO_LONG => array(
            'label' => 'Duration limit exceeded',
            'progressbar' => 'This tracks length exceeds the configured duration limit allowed',
            'labelclass' => 'uk-badge-danger',
            'progressbarclass' => 'uk-progress-danger'
        ),
        Media::STATUS_DURATION_TOO_SHORT => array(
            'label' => 'Duration too short',
            'progressbar' => 'This track is too short, a duration of at least 30 seconds is required',
            'labelclass' => 'uk-badge-danger',
            'progressbarclass' => 'uk-progress-danger'
        )
    );

    $uploadStatus = $status[$upload->status];
?>

<li data-uploadid="<?= $upload->id; ?>">
    <div class="uploaded-item">
        <p><div class="uk-badge <?= $uploadStatus['labelclass']; ?>"><?= $uploadStatus['label']; ?></div> <strong><?= $upload->title; ?></strong></p>

        <div class="uk-progress <?= $uploadStatus['progressbarclass']; ?>">
            <div class="uk-progress-bar" style="width: 100%;"><?= $uploadStatus['progressbar']; ?></div>
        </div>
    </div>
</li>
