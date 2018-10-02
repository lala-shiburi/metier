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
     * handles file upload for temporary file updload
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function handleTempDocUploadRequest($request){
        $filename = $this->saveDocToTemp($request->file);

        return $filename;
    }

    /**
     * checks if a file is a valid document them saves it in temp folder/directory
     * 
     * @return String //returns a unique file names
     */
    private function saveDocToTemp($file){
        if(in_array($file->getClientOriginalExtension(), $this->acceptableDocs)){
            return $this->saveFileTempDir($file);
        }

        exit('file invalid. file should be either for the following : '.implode(',',$this->$acceptableDocs));
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
