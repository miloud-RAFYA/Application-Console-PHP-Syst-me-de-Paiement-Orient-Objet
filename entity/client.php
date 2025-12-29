<?php


class client
{

    private $name;
    private $email;
    private  $id;

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
    public function __get($name){
        return $this->$name;
    }
    public function setClientId($id)
    {
        $this->id = $id;

    }
  
    
    public function __toString()
    {
        return "numero de client est :".$this->id."\tName client :" . $this->name . " et email :" . $this->email."\n";
    }
}



