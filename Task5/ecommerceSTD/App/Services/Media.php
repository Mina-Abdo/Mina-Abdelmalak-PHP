<?php 
namespace App\Services;

class Media {
    private array $file;
    private string $newMediaName;
    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function upload(string $path) :bool
    {
        $this->newMediaName = uniqid() . '.' . $this->getFileExtension(); // 5sf1d5d1sa5d1df5da.jpg
        return move_uploaded_file($this->file['tmp_name'],$path . $this->newMediaName); // assets/img/users5sf1d5d1sa5d1df5da.jpg
    }


    public function delete(string $path) :bool
    {
        if(file_exists($path)){
            return unlink($path);
        }
        return false;
    }

    public function getFileExtension() :string
    {
       return explode('/',$this->file['type'])[1]; // image/png
    }

    /**
     * Get the value of newMediaName
     */ 
    public function getNewMediaName()
    {
        return $this->newMediaName;
    }
}