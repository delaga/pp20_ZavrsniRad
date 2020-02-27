<?php

class IndexController extends Controller
{

    public function prijava()
    {
        $this->view->render('prijava',[
            'poruka'=>'Unesite pristupne podatke',
            'korisnickoIme'=>''
        ]);
    }

    public function autorizacija()
    {
        if(!isset($_POST['korisnickoIme']) || 
        !isset($_POST['lozinka'])){
            $this->view->render('prijava',[
                'poruka'=>'Nisu postavljeni pristupni podaci',
                'korisnickoIme' =>''
            ]);
            return;
        }

        if(trim($_POST['korisnickoIme'])==='' || 
        trim($_POST['lozinka'])===''){
            $this->view->render('prijava',[
                'poruka'=>'Pristupni podaci obavezno',
                'korisnickoIme'=>$_POST['korisnickoIme']
            ]);
            return;
        }

        //$veza = new PDO('mysql:host=localhost;dbname=edunovapp20;charset=utf8',
        //'edunova','edunova');

        $veza = DB::getInstanca();

        	    //sql INJECTION PROBLEM
        //$veza->query('select lozinka from operater 
        //              where email=\'' . $_POST['email'] . '\';');
        $izraz = $veza->prepare('select * from korisnik 
                      where korisnickoIme=:korisnickoIme;');
        $izraz->execute(['korisnickoIme'=>$_POST['korisnickoIme']]);
        //$rezultat=$izraz->fetch(PDO::FETCH_OBJ);
        $rezultat=$izraz->fetch();

           /*  echo "<pre>";
            print_r($rezultat->lozinka);
            echo "</pre>"; */

        if($rezultat==null){
            $this->view->render('prijava',[
                'poruka'=>'Ne postojeći korisnik',
                'korisnickoIme'=>$_POST['korisnickoIme']
            ]);
            return;
        }
            #traženje
                echo "Upisana lozinka =" .$_POST['lozinka'] ."<br/>";
                echo "lozinka u bazi=" . $rezultat->lozinka ."<br/>";
               if(password_verify($_POST['lozinka'],$rezultat->lozinka)) {
                   echo "OK je";}
                   else{
                       echo "Nije dobro";
                   }
            # /traženje

        if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
            $this->view->render('prijava',[
                'poruka'=>'Neispravna kombinacija korisničko ime i lozinka',
                'korisnickoIme'=>$_POST['korisnickoIme']
            ]);
            return;
        }
        unset($rezultat->lozinka);
        $_SESSION['korisnik']=$rezultat;
        //$this->view->render('privatno' . DIRECTORY_SEPARATOR . 'nadzornaPloca');
        $npc = new NadzornaplocaController();
        $npc->index();
    }

    public function odjava()
    {
        unset($_SESSION['korisnickoIme']);
        session_destroy();
        $this->index();
    }

    public function index()
    {
        $poruka='hello iz kontrolera';
        $kod=22;

       
        $this->view->render('pocetna',[
            'p'=>$poruka,
            'k'=>$kod]
        );


    }
    public function onama()
    {
        $this->view->render('onama');
    }

    public function json()
    {
        $niz=[];
        $s=new stdClass();
        $s->naziv='PHP programiranje';
        $s->sifra=1;
        $niz[]=$s;
        //$this->view->render('onama',$niz);
        echo json_encode($niz);
    }

    public function test()
    {
     echo password_hash('e',PASSWORD_BCRYPT);
      // echo md5('mojaMala'); NE KORISTITI
    } 
}