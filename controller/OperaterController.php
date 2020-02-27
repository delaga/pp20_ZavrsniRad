<?php

class OperaterController # extends AdminController
{
    public function index()
    {   #kasnije makni
        $this->view = new View();
        
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from korisnik');
        $izraz->execute();
        $rezultati = $izraz->fetchAll();
           
        $this->view->render('privatno' . 
     DIRECTORY_SEPARATOR . 'operater' .
     DIRECTORY_SEPARATOR . 'index',[
         'podaci'=>$rezultati
     ]);
    }
}