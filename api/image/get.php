<?php
    require_once '../../classes/Image.php';

    $class = new \ReflectionClass('Image');

    $props = [];

    foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
        array_push($props, $property->getName());
    }


    $GETkeys = array_keys($_GET);
    if(empty($GETkeys) || array_search($GETkeys[0], $props) == false)
        die();


    $image = new Image();
    $images = $image->find($GETkeys[0], $_GET[$GETkeys[0]]);
    $JSONimages = json_encode($images);

    echo $JSONimages;
