<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;

trait FileManager
{
    private $acceptableDocs = array("pdf", "docx", "doc", "dotx");
    private $temp_folder = '/temp/';
    private $doc_folder = '/documents/';
    private $picture_folder = '/photos/';
    private $public_directory = '/../../public';

    /**
     * transfers doc from temp folder to designated folder
     * 
     * @param String //accepts temporary file's name
     * @param String //accepts intended filename
     * @param String //accepts designated folder
     * @return String //returns intended file concatenated with unique id
     */
    public function moveTempDoc($tempFile, $filename){
        $temp = 'storage/temp/'.$tempFile;
        $ext = pathinfo($temp, PATHINFO_EXTENSION);
        $newFilename = $filename.$this->returnMD5FileName().'.'.$ext;
        rename($temp, 'storage'.$this->doc_folder.$newFilename);

        return $newFilename;
    }

    /**
     * handles file upload for temporary file upload
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function handleTempDocUploadRequest($request){
        $filename = $this->saveDocToTemp($request->file);

        return $filename;
    }

    /**
     * checks if a file is a valid document then saves it in temp folder/directory
     * 
     * @return String //returns a unique file names
     */
    private function saveDocToTemp($file){
        if(in_array($file->getClientOriginalExtension(), $this->acceptableDocs)){
            return $this->saveFileTempDir($file);
        }

        exit('file invalid. file should be either of the following : '.implode(',',$this->$acceptableDocs));
    }
    
    /**
     * saves file in temp folder
     * 
     * @param Illuminate\Http\File //accepts file
     * @return String //returns a hashed file name
     */
    private function saveFileTempDir($file){
        $this->findOrCreateFolder(public_path('/'),'/storage');
        $this->findOrCreateFolder(public_path('/storage'), $this->temp_folder);
        $filename = $this->returnMD5FileName().'.'.$file->getClientOriginalExtension();

        $file->move(public_path('/storage'.$this->temp_folder), $filename);

        return $filename;
    }

    /**
     * saves base64 file in temp folder
     * 
     * @param String //base64 of file
     * @return String //returns a hashed file name
     */
    private function saveBase64FileTempDir($base64){

        $name = generateFileName(md5(time()),'temp','.png');

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));

        findOrCreatePublicStorageFolder();
        
        if (!file_exists(public_path('/storage/temp/'))){
            mkdir(public_path('/storage/temp'));
        }
        
        file_put_contents(public_path('/storage/temp/').$name, $data);

        return $name;
    }

    /**
     * returns unique string for file name
     * 
     * @return String
     */
    private function returnMD5FileName(){
        return md5(microtime());
    }

    /**
     * this code creating checking if a folder/directory exist.
     * and if not, will create the folder/directory
     * 
     * @param String //accepts the parent folder/directory
     * @param String //accepts folder/directory name
     * 
     * @return Boolean
     */
    private function findOrCreateFolder($parentDir, $dir){
        if(!file_exists($parentDir.$dir)){
            mkdir($parentDir.$dir);
            return false;
        }
        return true;
    }
}
