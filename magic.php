<?php
function before($post_date){
    $curr_date = date("U");
    if(($curr_date - $post_date) < 60) {
        return "less than a minute ago";
    }
    elseif (($curr_date - $post_date) < 60*60) {
        return "in the last hour";
    }
    elseif ((($curr_date - $post_date) < 60*60*24)) {
        return "today";
    }
    else {
        return "";
    }
}
?>