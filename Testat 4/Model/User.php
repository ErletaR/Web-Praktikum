<?php
use JsonSerializable;
namespace Model;
class User implements JsonSerializable {
    private $username = null;

    function __construct($username){
        $this->username = $username;
    }

    function get_username(){
        return $this ->username;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
        }
        
}
?>
