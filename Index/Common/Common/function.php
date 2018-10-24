<?php
/**
 * If you use Nginx or any other Reverse Proxy, you should use a function (like proxy_set_header in nginx)
 * to set the header X-Real-IP, to record the ip from user or the last proxy
 * @return array all forward ip, if is exist
 */
function curIps() {
    $ips = array();
    if (isset($_SERVER['HTTP_X_REAL_IP'])) {
        $real_ip = $_SERVER['HTTP_X_REAL_IP'];
    } else {
        $real_ip = $_SERVER['REMOTE_ADDR'];
    }
    $ips[0] = $real_ip;

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwardIps = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        if (is_array($forwardIps)) {
            if ($forwardIps[0] == $real_ip) {
                $ips = $forwardIps;
            } else {
                $ips = array_merge($ips, $forwardIps);
            }
        }
    }
    return $ips;
}

/**
 * If you use Nginx or any other Reverse Proxy, you should use a function (like proxy_set_header in nginx)
 * to set the header X-Real-IP, to record the ip from user or the last proxy
 * @return string user real ip
 */
function curIp() {
    if (isset($_SERVER['HTTP_X_REAL_IP'])) {
        return $_SERVER['HTTP_X_REAL_IP'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}