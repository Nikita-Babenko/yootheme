<?php

// Title
if ($element['show_title'] && trim($marker['title'])) {
    echo "<strong class=\"uk-display-block uk-margin\">{$marker['title']}</strong>";
}

echo $marker['content'];
