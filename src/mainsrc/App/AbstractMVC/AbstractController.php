<?php

namespace App\App\AbstractMVC;

abstract class AbstractController {

    public function pageload($dir, $view, $variablen){

        extract($variablen);
        require_once __DIR__ . "/../../$dir/MVC/Views/$view.php";
    }

    public function getBestimmteAngebote(array $allOffers, string $ids): array{
        # Der Funktion prüft, ob eine ID in der Liste der Angebote enthalten ist und gibt damit alle Angebote zurück auf die, das zutrifft
        $list = explode(',', $ids);
        foreach ($allOffers as $value){
            if(in_array($value->id, $list)){
                $gesuchteAngebote[] = $value;
            }
        }
        return $gesuchteAngebote;
    }
}