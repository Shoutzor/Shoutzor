<?php
    /*
    This template requires these variables to be set!

    $route = '';
    $page = 1;
    $total = 10;
    */
?>

<ul class="uk-pagination">
    <?php

    if($page > 1):
        $minus = ($page > 5) ? 5 : $page - 1;
        $prev = ($page - $minus) < 1 ? 1 : $page - $minus ;

        if($page > 2):
            echo '<li><a href="' . $view->url($route, ['page' => 1, "q" => $q]) . '"><i class="uk-icon-angle-double-left"></i> First</a></li>';
        endif;

        echo '<li><a href="' . $view->url($route, ['page' => $page-1, "q" => $q]) . '"><i class="uk-icon-angle-left"></i> Prev</a></li>';

        for($p = $prev; $p<$page; $p++):
            echo '<li><a href="' . $view->url($route, ['page' => $p, "q" => $q]) . '">' . $p . '</a></li>';
        endfor;
    endif;

    echo '<li class="uk-active"><span>' . $page . '</span></li>';

    if($total > $page):
        $plus = ($total-$page > 5) ? 5 : $total - $page;
        $max = ($page + $plus) > $total ? $total : $page + $plus ;

        for($p = $page+1; $p<=$max; $p++):
            echo '<li><a href="' . $view->url($route, ['page' => $p, "q" => $q]) . '">' . $p . '</a></li>';
        endfor;

        echo '<li><a href="' . $view->url($route, ['page' => $page+1, "q" => $q]) . '">Next <i class="uk-icon-angle-right"></i></a></li>';

        if($page < $total-1):
        echo '<li><a href="' . $view->url($route, ['page' => $total, "q" => $q]) . '">Last <i class="uk-icon-angle-double-right"></i></a></li>';
        endif;

    endif;

    ?>
</ul>
