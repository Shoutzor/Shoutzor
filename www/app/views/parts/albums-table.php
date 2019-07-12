<?php
    use Xorinzor\Shoutzor\App\Utility;
?>

<table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
    <thead>
        <tr>
            <th class="uk-width-1-2">Title</th>
            <th class="uk-width-1-2">Artist(s)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($albums as $album): ?>
            <tr>
                <td><?= '<a href="' . $view->url('@shoutzor/album/view', ['id' => $album->id]) . '">' . $album->title . '</a>'; ?></td>
                <td>
                    <?php
                        if(isset($album->artist) && !is_null($album->artist) && count($album->artist) > 0) {
                            $artistList = '';

                            foreach($album->artist as $artist) {
                                if(!empty($artistList)) {
                                    $artistList .= ', ';
                                }

                                $artistList .= '<a href="' . $view->url('@shoutzor/artist/view', ['id' => $artist->id]) . '">' . $artist->name . '</a>';
                            }

                            echo $artistList;
                        } else {
                            echo __('Unknown');
                        }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
