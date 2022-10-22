<?php
namespace App\Http\Requests;

use App\Database\Models\Model;

class Validation {
    private string $input; // 
    private string $inputName; // 
    private array $errors = [];
    private array $restrictedValues = [
        null,'',[],
    ];
    private array $file;
    public function required() :self
    {
        if(in_array($this->input,$this->restrictedValues)){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} is required";
        }
        return $this;
    }
    public function string() :self
    {
        if(! is_string($this->input)){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} must be string";
        }
        return $this;
    }

    public function between(int $min,int $max) :self
    {
        if(! (strlen($this->input) >= $min && strlen($this->input) <= $max)){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} must be between {$min} , {$max}";
        }
        return $this;
    }

    public function digits(int $digits) :self
    {
        if(strlen($this->input)  !== $digits){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} must be {$digits} digits";
        }   
        return $this;
    }

    public function  numeric() :self
    {
        if(! is_numeric($this->input)){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} must be a number";
        }   
        return $this;
    }

    public function regex(string $pattern,$message=null)  :self
    {
        if(! preg_match($pattern,$this->input)){
            $this->errors[$this->inputName][__FUNCTION__] = $message ?? "{$this->inputName} invalid";
        }
        return $this;
    }

    public function unique($table,$column)  :self
    {
        $query = "SELECT * FROM {$table} WHERE {$column} = ?";
        $model = new Model;
        $stmt = $model->conn->prepare($query);
        if(! $stmt){
            $this->errors[$this->inputName][__FUNCTION__] = "Something went wrong";
        }   
        $stmt->bind_param('s',$this->input);
        $stmt->execute();
        if($stmt->get_result()->num_rows == 1){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} Already Exists";
        }
        return $this;
    }
    public function exists($table,$column)  :self
    {
        $query = "SELECT * FROM {$table} WHERE {$column} = ?";
        $model = new Model;
        $stmt = $model->conn->prepare($query);
        if(! $stmt){
            $this->errors[$this->inputName][__FUNCTION__] = "Something went wrong";
        }   
        $stmt->bind_param('s',$this->input);
        $stmt->execute();
        if($stmt->get_result()->num_rows == 0){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} Not Exist";
        }
         return $this;
    }

    public function confirmed($password_confirmation) :self
    {
        if($this->input !== $password_confirmation){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} not confirmed";
        }
        return $this;
    }
    public function in(array $values)  :self
    {
        if(! in_array($this->input,$values)){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} accepted values " . implode(', ',$values);
        }
        return $this;
    }

    public function size(int $maxSize) :self
    {
        if($this->file['size'] > $maxSize){
            $this->errors[$this->inputName][__FUNCTION__] = "Max Size : {$maxSize} Bytes";
        }
        return $this;
    }

    public function extensions(array $availableExtensions) :self
    {
        $fileExtension = explode('/',$this->file['type'])[1]; //png
        if(! in_array($fileExtension,$availableExtensions)){
            $this->errors[$this->inputName][__FUNCTION__] = "Allowed Extensions are:" . implode(', ' ,$availableExtensions);
        }
        return $this;
    }

    public function matchOldPassword( $hashedPassword) 
    {
       if(! password_verify($this->input,$hashedPassword)){
        $this->errors[$this->inputName][__FUNCTION__] = "Wrong Password";

       }
        return $this;

    }

    /**
     * Set the value of input
     *
     * @return  self
     */ 
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Set the value of inputName
     *
     * @return  self
     */ 
    public function setInputName($inputName)
    {
        $this->inputName = $inputName;

        return $this;
    }

    /**
     * Get the value of errors
     */ 
    public function getErrors()
    {
        return $this->errors;
    }

    public function getError(string $inputName) :?string
    {
        if(isset($this->errors[$inputName])){
            foreach($this->errors[$inputName] AS $error){
                return $error;
            }
        }
        return null;
    }

    public function getErrorMessage(string $inputName)
    {
        return "<p class='text-danger font-weight-bold' > ".$this->getError($inputName)." </p>";
    }

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


    
}
// SOLID