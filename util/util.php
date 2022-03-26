<?php

    function get_query_expressions($arr) {
        $query_array = array();
        foreach($arr as $key => $value) {
            if ($value != '') {
                $query_array[] = $key . ' = ' . $value;
            }
        }
        return $query_array;
    }
?>