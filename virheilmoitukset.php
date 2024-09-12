<?php
/* Virheilmoituksia on ainakin kolmea tyyppiä:
1. Käyttäjän syötteiden virheilmoitukset, jotka näytetään lomakkeella
2. Tietokannan tai muut palvelimen virheilmoitukset, jotka näytetään lomakkeella
3. Muut palvelimen virheilmoitukset, jotka näytetään esim. lomakkeen alla
*/ 


$errors ??= [];
$kentat ??= ['title','description','release_year','language_id','rental_duration','rental_rate','length','replacement_cost','rating','special_features'];
$kentat_suomi ??= ['elokuvan nimi','kuvaus','julkaisuvuosi','kieli','vuokrausaika','vuokra','kesto','korvaushinta','ikäraja','erikoisominaisuudet'];
$pakolliset ??= ['title','description','release_year','language_id','rental_duration','rental_rate','length','replacement_cost','rating'];
$kaannokset = array_combine($kentat,$kentat_suomi);



// custom pattern's for add new movie!
$patterns['title'] = "/^[a-zA-Z0-9.,!?]{3,255}$/";
$patterns['description'] = "/^[a-zA-Z0-9.,!?]{5,1000}$/";
$patterns['release_year'] = "/^(19[5-9]\d|20\d{2})$/";
$patterns['language_id'] = "/^\d+$/";
$patterns['rental_rate'] = "/^(0\.[9][9]|[1-4]\.[0-9][0-9])$/";
$patterns['rental_rate'] = "/^([1-4](\.\d{1,2})?|5(\.0{1,2})?)$/";
$patterns['length'] = "/^(?:[5-9]|[1-9]\d|1[0-9]\d|200)$/";
$patterns['replacement_cost'] = "/\b(9|[1-2][0-9]|30)\b/";
$patterns['rating'] = "/^(G|PG|PG-13|R|NC-17)$/";
$patterns['special_features'] = "/^(Trailers|Commentaries|Deleted Scenes|Behind the Scenes)$/";

function randomString($length = 3){
    return bin2hex(random_bytes($length));
    }

function kaannos($kentta){
    return $GLOBALS['kaannokset'][$kentta];
    }
    
function validationMessages($kentat){   
    foreach ($kentat as $input) {
        $kentta = kaannos($input);   
        $validationMessage[$input]['customError'] = "Virheellinen $kentta";
        $validationMessage[$input]['patternMismatch'] = "Virheellinen $kentta";
        $validationMessage[$input]['rangeOverflow'] = "Liian suuri $kentta";
        $validationMessage[$input]['rangeUnderflow'] = "Liian pieni $kentta";
        $validationMessage[$input]['stepMismatch'] = "Väärän kokoinen muutos";
        $validationMessage[$input]['tooShort'] = "Liian lyhyt $kentta";
        $validationMessage[$input]['tooLong'] = "Liian pitkä $kentta";
        $validationMessage[$input]['typeMismatch'] = "Väärän tyyppinen $kentta";
        $validationMessage[$input]['valueMissing'] = ucfirst($kentta)." puuttuu";
        $validationMessage[$input]['valid'] = "Oikea arvo";
        }   
    return $validationMessage;
    }
    
    function pattern($kentta) {
        return trim($GLOBALS['patterns'][$kentta],"/");
        }
        
    function error($kentta) {
        return $GLOBALS['errors'][$kentta] ?? $GLOBALS['virhetekstit'][$kentta]['puuttuu'];
        }
    
    function arvo($kentta) {
        $error = $GLOBALS['errors'][$kentta] ?? false;
        return ($error) ? "" : $_POST[$kentta] ?? "";
        }   
        
    function is_invalid($kentta) {        
        return (isset($GLOBALS['errors'][$kentta])) ? "is-invalid" : "";
        }       
    
$virheilmoitukset = validationMessages($kentat);
// custom virheilmoitukset
$virheilmoitukset['title']['valueMissing'] = "Otsikko on pakollinen";
$virheilmoitukset['description']['valueMissing'] = "Kuvaus on pakollinen";
$virheilmoitukset['release_year']['valueMissing'] = "Julkaisuvuosi on pakollinen";
$virheilmoitukset['language_id']['valueMissing'] = "Kieli-ID on pakollinen";
$virheilmoitukset['rental_duration']['valueMissing'] = "Vuokrausaika on pakollinen";
$virheilmoitukset['rental_rate']['valueMissing'] = "Vuokrahinta on pakollinen";
$virheilmoitukset['length']['valueMissing'] = "Pituus on pakollinen";
$virheilmoitukset['replacement_cost']['valueMissing'] = "Korvauskustannus on pakollinen";
$virheilmoitukset['rating']['valueMissing'] = "Arvostelu on pakollinen";
$virheilmoitukset['special_features']['valueMissing'] = "Vähintään yksi erikoisominaisuus on valittava";
$virheilmoitukset_json = json_encode($virheilmoitukset);




?>