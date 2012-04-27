<?php


    function printGameLetter() {
        echo '<div style="width:100%;text-align:center;" class="filter_letters">';
        $links = '';
        foreach (array_keys($this->criterias) as $key) {
            if ($key == $this->filter) {
                $links .=  $key;
            } else {
                if ($key == '#')
                    $links .= '<a href="?module=support#NUMBERS">' . $key . '</a>';
                else
                    $links .= '<a href="?module=support#'.$key.'">' . $key . '</a>';
            }
            $links .= ' ';
        }
        echo $links;

        echo '</div>';
    }


    
?>