<?php
  class Paginator
  {
    public $name = 'page';
    public $tempName = 'test';
    public $extention = '.php';
    public $_season;
    public $_roman;
    public $dir;
    // Constructeur int saison, int roman,
    public function __construct($saison, $roman){
      $this->_season = $saison;
      $this->_roman = $roman;
      $this->dir = '../saison'.$this->_season.'/'.$this->_roman.'/'.'includes/';
    }

    //retourne la date avec H,min,S
    //sert à enregistrer
    function today(){
        return date("d-m-Y").'-'.date('H').'h'.date('i').'min'.date('s');
    }

    //sauvegarde des fichiers avant de renommer
    function saveDir(){
      $dir_dest = '../old/'.$this->_roman.$this->today();
      mkdir($dir_dest, 0755);
      $dir_iterator = new RecursiveDirectoryIterator($this->dir, RecursiveDirectoryIterator::SKIP_DOTS);
      $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
      foreach($iterator as $element){
         if($element->isDir()){
           mkdir($dir_dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
         }
         else{
            copy($element, $dir_dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
         }
      }
      return true;
    }

    //lecture du repertoir et retourne un tableau avec toutes les pages courantes
    function readDir($query){
      $toReturn = array();
      $dossier = opendir($this->dir);
      while(false !== ($fichier = readdir($dossier))){
        if(preg_match('/'.$query.'/i',$fichier)){
          array_push($toReturn,$fichier);
          // echo $fichier.'<br />';
        }
      }
      return $toReturn;
    }

    //Deplacer un fichier
    function moveToTemp($file){
      rename($file,'../../../temp/'.$file);
    }

    //renomme le fichier avec le bon nom et le deplace dans l'includes
    function renamePageAndMove($uploadfile, $page){
      rename($uploadfile,$this->dir.'page'.$page.'.php');
    }

    function renamePage($file, $name){
      rename($file,$name);
    }

    //efface le le fichier
    function unlink($file){
      unlink($file);
    }

    //renomme tous les fichiers
    //$files = resultat de readDir()
    //$pattern = nom du fichier à rechercher
    function renameAll($files,$pattern, $delete){
      $patterns = '/'.$pattern.'/';
      for($i = 0; $i <= sizeof($files); $i++){
        if($delete){
          //pour la suppression d'une page on fait le nom courant -1
          $name = intval(preg_replace('/[^0-9]+/', '', $files[$i]), 10)-1;
          $name = $this->name.$name.$this->extention;
        }
        else{
          $name = preg_replace($patterns,$this->name,$files[$i]);
        }
        rename($this->dir.$files[$i], $this->dir.$name);
      }
    }

    //renomme les fichiers dans l'includes, à faire avant d'injecter le nouveau fichier
    //$files = tableau de fichier provenant d'un readDir
    //$from = numéro de page supprimé par l'utilisateur
    //$name = nom donné aux pages
    function renameFromTo($files, $from, $name){
      for($i = $from; $i <= sizeof($files); $i++){
        $number = $i+1;
        rename($this->dir.$files[$i],$this->dir.$name.$number.$this->extention);
      }
    }

    function renameBetween($files, $move, $to){
      if($move < $to){
        for ($i=$move+1; $i <= $to ; $i++) {
          rename($this->dir.$files[$i],$this->dir.$this->tempName.$i.$this->extention);
        }
      }
      else if($move > $to){
        for ($i=$to; $i <= $move-1 ; $i++) {
          $int = intval(preg_replace('/[^0-9]+/', '', $files[$i]), 10)+1;
          rename($this->dir.$files[$i],$this->dir.$this->tempName.$int.$this->extention);
        }
      }
    }
}
