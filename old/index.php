<?php
$name='ahmed';
$int=0;
$float=1.5;
$bool=true;
$array=array('ahmed','mohamed','ali');
// echo $array[1];
// print_r($array);
$array2=['ahmed','mohamed','ali'];
$array3=[
    'name' => 'ahmed',
    'phone' => '012345798'
];
if($int >  0) {
    echo 'it is positive';
}elseif ($int == 0){
    echo 'zero';
}else{
    echo 'it is negative';
}
foreach($array as $data){

    echo $data . '<br>';
}

?>