<?php


namespace Etronic\PhpMvcCore;

use Etronic\PhpMvcCore\db\DbModel;

abstract class UserModel extends DbModel{

    abstract public function get_display_name() : string;
}