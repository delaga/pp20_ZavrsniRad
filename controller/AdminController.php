<?php

class AdminController extends AutorizacijaController
{
    public function __construct()
    {
        parent::__construct();
        if($_SESSION['korisnik']->uloga!=='3'){
            $ic = new IndexController();
            $ic->odjava();
            exit;
        }
    }
}