<?php
namespace App\Http\Requests;

use App\Database\Models\Model;

class Validation{
    private string $input;
    private string $inputName;
    private array $errors=[];
    public function required() :self 
    {
        if(! isset($this->input)){
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
    public function between(int $min , int $max) :self
    {
        if(! (strlen($this->input)>=$min && strlen($this->input) <=$max)){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} invalid length";
        }
        return $this;
    }
    public function regex(string $pattern , $message=null) :self
    {
        if( ! preg_match($pattern,$this->input)){
            $this->errors[$this->inputName][__FUNCTION__] = $message ?? "{$this->inputName} invalid input";
        }

        return $this;
    }
    public function unique($table , $column) :self
    {
        $query = "SELECT * FROM {$table} WHERE {$column} = ?";
        $model = new Model;
        $stm = $model->connect->prepare($query);
        if(! $stm){
            $this->errors[$this->inputName][__FUNCTION__] = $message ?? "something went wrong";
        }
        $stm->bind_param("s" , $this->input);
        $stm->execute();
        if($stm->get_result()->num_rows == 1){
            $this->errors[$this->inputName][__FUNCTION__] = $message ?? "{$this->inputName} email already registered";
        }
        return $this;
    }
    public function exsists($table , $column) :self
    {
        $query = "SELECT * FROM {$table} WHERE {$column} = ?";
        $model = new Model;
        $stm = $model->connect->prepare($query);
        if(! $stm){
            $this->errors[$this->inputName][__FUNCTION__] = $message ?? "something went wrong";
        }
        $stm->bind_param("s" , $this->input);
        if($stm->get_result()->num_rows == 0){
            $this->errors[$this->inputName][__FUNCTION__] = $message ?? "{$this->inputName} email already registered";
        }
        return $this;
    }
    public function digits($digits) :self
    {
        if(strlen($this->input) !== $digits){
            $this->errors[$this->inputName][__FUNCTION__] = $message ?? "{$this->inputName} must be {$digits} digits";
        }
        return $this;
    }
    public function numeric() :self
    {
        if(! is_numeric($this->input)){
            $this->errors[$this->inputName][__FUNCTION__] = $message ?? "{$this->inputName} must be numeric value";
        }
        return $this;
    }
    public function confirmed(string $password_verification) :self
    {
        if(($this->input) !== $password_verification){
            $this->errors[$this->inputName][__FUNCTION__] = "{$this->inputName} and password verification does not match";
        }
        return $this;
    }
    public function in(array $range) :self
    {
        if(! in_array($this->input , $range)){
            $this->errors[$this->inputName][__FUNCTION__] = "please make sure to select a value for {$this->inputName}";
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

    public function getError($inputName) :?string
    {
        if(! empty($this->errors[$inputName])){
            foreach($this->errors[$inputName] AS $error){
                return $error;
            }
        }
        return null;
    }
    public function getErrorMessage($inputName) 
    {
        return "<p class='alert text-danger mt-2'>{$this->getError($inputName)}</p>";
    }
    
}