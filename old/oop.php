<?php
class mobile{
    public $cam; // property
    public $dailing;
    public $ram;
    public function printCam(){ // method
        echo $this->cam; // this reefer to object
    }
}
$mobileObject=new mobile();
$mobileObject->cam='true';
$mobileObject->dailing='true';
$mobileObject->ram='true';

$mobileObject2=new mobile();
$mobileObject2->cam='false';
// $mobileObject->printCam();

class iphone extends mobile{
    public function printram(){ // method
        echo $this->ram; // this reefer to object
    }
}
$iphoneObject=new iphone();
$iphoneObject->cam='yes';
$iphoneObject->ram='no';
// $iphoneObject->printram();
$mobileObject2->printram();
