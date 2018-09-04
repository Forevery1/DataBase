<?php
/**
 * Created by IntelliJ IDEA.
 * User: Forevery
 * Date: 2018/9/3
 * Time: 21:59
 */

spl_autoload_register(function ($class_name) {
    require_once  $class_name . '.php';
});
