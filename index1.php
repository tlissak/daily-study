<?php

apache_setenv('no-gzip', 'on');
ini_set('zlib.output_compression', 'off');
ini_set('implicit_flush', 'on');
ob_implicit_flush(1);


if (ob_get_level() == 0) {
    ob_start();
}
function p($s){
    echo '<pre>' ;
    var_dump($s);
    echo '</pre>';

    ob_flush();
    flush();

}



$pdo = new PDO('sqlite:'.dirname(__FILE__).'/cp1.db');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


function insert_book($json_file,$book){

    global $pdo;

    $sth = $pdo->prepare ("INSERT INTO torah (ref,text,chumash,perek,pasuk) VALUES (?,?,?,?,? )") ;

    $torah = ['','BERESHIT','SHEMOT','VAIKRA','BAMIDBAR','DEVARIM'] ;
    $book_name = $torah[$book] ;
    p( 'Chumash '. $book_name . ' start');

    $string = file_get_contents($json_file);
    $json_a = json_decode($string, true);
    $i_perek = 1;
    foreach ($json_a['text'] as $chapter){
        $j_pasuk=1;
        foreach ($chapter as $pasuk){
            $sth->execute(["${book_name}-${i_perek}-${j_pasuk}",$pasuk,$book,$i_perek,$j_pasuk]) ;
            $j_pasuk++;
        }
        $i_perek++ ;
    }
}

function insert_rashi($json_file,$book){
    global $pdo;
    $sth = $pdo->prepare('INSERT INTO rashi (text,chumash,perek,pasuk) VALUES (?,?,?,?)') ;

    $torah = ['','BERESHIT','SHEMOT','VAIKRA','BAMIDBAR','DEVARIM'] ;
    $book_name = $torah[$book] ;
    p( 'Rashi '. $book_name . ' start');

    $string = file_get_contents($json_file);
    $json_a = json_decode($string, true);
    $i_perek = 1;
    foreach ($json_a['text'] as $chapter){
        $j_pasuk=1;
        foreach ($chapter as $pasuk){
            foreach ($pasuk as $rashi_comment) {
                $sth->execute([ $rashi_comment,$book ,$i_perek,$j_pasuk]) ;
            }

            $j_pasuk++;
        }
        $i_perek++ ;
    }
}

for ($i_book =1; $i_book < 6 ; $i_book ++){
   // insert_book("src/c-${i_book}.json",$i_book);
   // insert_rashi("src/r-${i_book}.json",$i_book);
}
//
ob_end_flush();