<?php

namespace Etronic\PhpMvcCore\form;
use Etronic\PhpMvcCore\Model;
use Etronic\PhpMvcCore\form\InputField;

class Form{

public static function begin($action,$method){

    echo  ( sprintf('<form action="%s" method="%s" >',$action,$method));




    return new Form();
}


public  static function end(){

    echo '</form>';
}

public function field(Model $model, $attribute){

    return new InputField($model,$attribute);
}

}