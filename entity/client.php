<?php


class client
{

    public $name;
    public $email;


    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function setClientName($name, $email)
    {
        $this->name = $name;

    }
    public function setClientEmail($email)
    {
        $this->email = $email;
    }
    public function getClientName()
    {
        return $this->name;

    }
    public function getClientEmail()
    {
        return $this->email;
    }
    public function __toString()
    {
        return "Name client :" . $this->name . " et email :" . $this->email."\n";
    }
}



