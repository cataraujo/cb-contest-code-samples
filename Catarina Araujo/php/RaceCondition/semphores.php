<?php
if (!function_exists('sem_get')) {
    function sem_get($key) {
        return fopen(__FILE__ . '.sem.' . $key, 'w+');
    }
    function sem_acquire($sem_id) {
        return flock($sem_id, LOCK_EX);
    }
    function sem_release($sem_id) {
        return flock($sem_id, LOCK_UN);
    }
}



?>