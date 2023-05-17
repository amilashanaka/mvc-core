<?php


namespace etronic\Core;

use etronic\Core\db\DbModel;

abstract class UserModel extends DbModel{

    abstract public function get_display_name() : string;
}