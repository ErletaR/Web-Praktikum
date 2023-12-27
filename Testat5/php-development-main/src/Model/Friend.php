<?php
namespace Model;
use JsonSerializable;
class Friend implements JsonSerializable {
    private $username = null;
    private $status = null;

    function __construct($username= NULL){
        $this->username = $username;
    }

    function get_username(){
        return $this ->username;
    }

    function get_status(){
        return $this ->status;
    }

    function set_accepted(){
        $this->status = "accepted";
    }

    function set_dismissed(){
        $this->status = "dismissed";
    }

    public function jsonSerialize() {
        return get_object_vars($this);
        }

    public static function fromJson($data){
        $user = new Friend();
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
            }
            return $user;
    }
        
}
?>
