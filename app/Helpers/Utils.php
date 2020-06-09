<?php

namespace App\Helpers;


class Utils{

    private $roles = ['Owner','Editor','Follower'];
    
    public function getRole($role){
        return array_search($role,$this->roles)+1;
    }

    public function getRoleText($roleId){
        return $this->roles[$roleId-1];
    }
}