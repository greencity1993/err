<?php

    use Monolog\Logger;
    use PHPExiftool\Reader;
    use PHPExiftool\Driver\Value\ValueInterface;

    require_once 'classes/Image.php';
    require_once __DIR__ . '/vendor/autoload.php';

    $logger = new Logger('exiftool');
    $reader = Reader::create($logger);
    $uploadsFolder = '/var/www/html/uploads/';

    $metadatas = $reader->files($uploadsFolder)->all();


    $lookedMetaData = array('System:FileName', 'XMP-dc:Title', 'XMP-dc:Description', 'XMP-dc:Creator', 'XMP-photoshop:Country', 'IPTC:Caption-Abstract', 'IPTC:ObjectName');
    
    foreach ($metadatas as $metadata) {
        $image = new Image();
        $image->setOriginalName($metadata->executeQuery($lookedMetaData[0])->asString());
        $image->generteUniqueName();
        if(isImageOK($metadata, $lookedMetaData)){
            $image->setTitle($metadata->executeQuery($lookedMetaData[1])->asString());
            $image->setDescription($metadata->executeQuery($lookedMetaData[2])->asString());
            $image->setCreator($metadata->executeQuery($lookedMetaData[3])->asString());
            $image->setCountry($metadata->executeQuery($lookedMetaData[4])->asString());
            $image->setCaptionAbstract($metadata->executeQuery($lookedMetaData[5])->asString());
            $image->setObjectName($metadata->executeQuery($lookedMetaData[6])->asString());
            rename($uploadsFolder . $image->getOriginalName(), "/var/www/html/images/" . $image->getUniqueName());
            $image->save();
        }else{
            rename($uploadsFolder . $image->getOriginalName(), "/var/www/html/damaged/" . $image->getUniqueName());
        }

    }


    function isImageOK($metadata, $lookedMetaData){

        //is it corrupted?
        if (!getimagesize('/var/www/html/uploads/' . $metadata->executeQuery('System:FileName')->asString())){
            return false;
        }

        //does it have all necessary metadata?
        foreach($lookedMetaData as $b){
            if($metadata->executeQuery($b) == null){
                return false;
            }
        }  

        return true;       
    }










    