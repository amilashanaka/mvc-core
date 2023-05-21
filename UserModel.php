<?php


namespace etronic\core;

use etronic\core\db\DbModel;

abstract class UserModel extends DbModel{

    abstract public function get_display_name() : string;
}