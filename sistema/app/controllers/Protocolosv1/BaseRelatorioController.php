<?php

class BaseRelatorioController extends \BaseController {

    public function __construct() {

        \User::allowedCredentials(array(10, 20));
    }
}
