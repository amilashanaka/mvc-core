<?php


namespace etronic\phpmvc;

use etronic\phpmvc\db\DbModel;

abstract class UserModel extends DbModel{

    abstract public function get_display_name() : string;
}