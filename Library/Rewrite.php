<?php

class Library_Rewrite {
    
    static function rewrite($id, $title, $category, $page = null) {
        global $base_url;
        $title = Library_String::rename($title);
        $category = Library_String::rename($category);
        if($page != null) {
            return $base_url . "/" . $category . "/" . $title . "-" . $id . "/page-".$page;
        }
        else {
            return $base_url . "/" . $category . "/" . $title . "-" . $id;
        }
    }
}