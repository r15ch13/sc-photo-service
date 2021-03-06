<?php

    function return_error($code, $message) {
        http_response_code($code);
        exit(json_encode(array('error' => $message)));
    }

    function fetch_url($url, $user = NULL, $pass = NULL) {
        $response = new stdClass();
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        if($user !== NULL and $pass !== NULL) {
            curl_setopt($curl, CURLOPT_USERPWD, $user . ":" . $pass);
        }
        $response->body = curl_exec($curl);
        $response->code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        return $response;
    }

    function directory_size($dir) {
        $size = 0;
        $path = realpath($dir);
        if($path !== FALSE and $path != '' and file_exists($path)) {
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $size += $object->getSize();
            }
        }
        return $size;
    }

?>
