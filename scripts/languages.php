<?php
function traduccion($str, $lang){
    if ( $lang != null ){

        if ( file_exists('./lang/'.$lang.'.php') ){

            include('./lang/'.$lang.'.php');
            if ( isset($texts[$str]) ){
                $str = $texts[$str];
            }
        }
    }
    return $str;
}
?>