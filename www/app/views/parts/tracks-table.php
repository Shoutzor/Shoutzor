<?php
    use Xorinzor\Shoutzor\App\Utility;
?>

<table class="uk-table uk-table-hover uk-table-striped uk-table-condensed tracks-table">
    <thead>
        <tr>
            <th class="uk-width-4-10">Title</th>
            <th class="uk-width-2-10">Artist(s)</th>
            <th class="uk-width-2-10">Album(s)</th>
            <th class="uk-width-2-10">Duration</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tracks as $track): ?>
            <tr class="track">
                <td class="title"><a data-music="<?= $track->id; ?>"><?= $track->title; ?></a></td>
                <td class="artist">
                    <ul>
                        <?php
                            if(isset($track->artist) && !is_null($track->artist) && count($track->artist) > 0) {
                                foreach($track->artist as $artist) {
                                    echo '<li><a href="' . $view->url('@shoutzor/artist/view', ['id' => $artist->id]) . '">' . $artist->name . '</a></li>';
                                }
                            } else {
                                echo '<li>' . __('Unknown') . '</li>';
                            }
                        ?>
                    </ul>
                </td>
                <td class="album">
                    <ul>
                        <?php
                            if(isset($track->album) && !is_null($track->album) && count($track->album) > 0) {
                                foreach($track->album as $album) {
                                    echo '<li><a href="' . $view->url('@shoutzor/album/view', ['id' => $album->id]) . '">' . $album->title . '</a></li>';
                                }
                            } else {
                                echo '<li>' . __('Unknown') . '</li>';
                            }
                        ?>
                    </ul>
                </td>
                <td class="duration"><?= Utility::secondsToTime($track->duration); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
