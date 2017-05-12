<?php

/**
 * 根据参数组装、修改url
 *
 * @param $url string
 * @param $parameters array 参数，结构如下
 * array(
 *   'scheme'   => 'http', // OR https
 *   'host'     => 'localhost',
 *   'port'     => 80, // OR NULL
 *   'user'     => '', 
 *   'password' => '',
 *   'path'     => '',
 *   'query'    => array(),
 *   'fragment' => '',
 * );
 *
 * @return string url
 */
if (!function_exists('url_build')) {
    function url_build($url, $parameters)
    {
        $url_info = parse_url($url);
        $scheme = isset($parameters['scheme']) ? "{$parameters['scheme']}://" : (isset($url_info['scheme']) ? "{$url_info['scheme']}://" : '');
        $_pass = isset($parameters['pass']) ? "{$parameters['pass']}" : (isset($url_info['pass']) ? "{$url_info['pass']}" : '');
        $_user = isset($parameters['user']) ? "{$parameters['user']}" : (isset($url_info['user']) ? "{$url_info['user']}" : '');
        $userpass = $_user && $_pass ? "{$_user}:{$_pass}@" : '';

        $host = isset($parameters['host']) ? "{$parameters['host']}" : (isset($url_info['host']) ? "{$url_info['host']}" : '');
        $port = isset($parameters['port']) ? ":{$parameters['port']}" : (isset($url_info['port']) ? ":{$url_info['port']}" : '');
        $path = isset($parameters['path']) ? "{$parameters['path']}" : (isset($url_info['path']) ? "{$url_info['path']}" : '');
        $fragment = isset($parameters['fragment']) ? "#{$parameters['fragment']}" : (isset($url_info['fragment']) ? "#{$url_info['fragment']}" : '');
        // 这两步，将url中的query与当前的$_GET参数合并，$_GET是补充参数
        parse_str(isset($url_info['query']) ? $url_info['query'] : '', $query_part);
        $query = http_build_query((isset($parameters['query']) ? $parameters['query'] : array()) + $query_part);
        $query = $query ? "?{$query}" : '';
        $new_url = "{$scheme}{$userpass}{$host}{$port}{$path}{$query}{$fragment}";

        return $new_url;
    }
}
