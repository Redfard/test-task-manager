<?php

function removeQueryStringVar($var, $firstAmpersand = true) {
    $queryStr = $_SERVER['QUERY_STRING'];

    if (!$queryStr) {
        return null;
    }

    $url = preg_replace(
        '/(.*)(\?|&)*' . $var . '=[^&]+?(&)(.*)/i',
        '$1$2$4',
        ($firstAmpersand ? '&' : '?') . $_SERVER['QUERY_STRING'] . '&'
    );
    $url = substr($url, 0, -1);

    return $url;
}