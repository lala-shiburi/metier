<?php

function saveBase64Photo($base64data,$name){
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));

    findOrCreatePublicStorageFolder();
    
    if (!file_exists(public_path('/storage/photos/'))){
        mkdir(public_path('/storage/photos'));
    }
    
    file_put_contents(public_path('/storage/photos/').$name, $data);
}

function saveDocument($file,$name){

    findOrCreatePublicStorageFolder();
    if (!file_exists(public_path('/storage/documents/'))){
        mkdir(public_path('/storage/documents'));
    }

    $arrayExtensions = array("pdf", "docx", "doc", "dotx");
    $extension = $file->getClientOriginalExtension();
    $file_name = $name;

    if (in_array($extension, $arrayExtensions))
    {
        $file->move(
            public_path('/storage/documents'), $file_name
        );

        return true;
    }

    exit("file not valid!");
}

function findOrCreatePublicStorageFolder(){
    if (!file_exists(public_path('/storage/'))){
        mkdir(public_path('/storage'), 0777, true);
    }
}

function generateFileName($id,$type, $extension){
    return $id.'_'.$type.'_'.time().$extension;
}

function convertDateOrFail($date){
    $_date = explode('/',$date);

    if(!checkdate($_date[0],$date[1],$date[2])){
        exit('something went wrong');
    }

    return $_date[2].'-'.$_date[0].'-'.$_date[1];
}

function generateImageBase64($path){
    $path = public_path('images/member-placeholder.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}