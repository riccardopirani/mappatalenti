<?php 
function form_mappa_talenti_shortcode($atts) {
     global $ek_map;
 
     // Imposta i parametri predefiniti
     $atts = shortcode_atts(
         [
             'slug_mappa' => '', // Valore predefinito vuoto
             'lingua' => ''      // Valore predefinito vuoto
         ],
         $atts,
         'form_mappa'
     );
 
     // Passa i parametri alla funzione `form_mappa_talenti`
     return $ek_map->form_mappa_talenti($atts['slug_mappa'], $atts['lingua']);
 }
 
 add_shortcode('form_mappa', 'form_mappa_talenti_shortcode');


function form_registrazione_shortcode() {
     global $ek_masterBooking;
     return $ek_masterBooking->form_registrazione_utente(get_the_ID());
}

add_shortcode('form_registrazione', 'form_registrazione_shortcode'); 


function reservedArea_days_shortcode($atts) {
     extract(shortcode_atts(array(
          'user' => false,
     ), $atts));

     global $ek_reservedArea;
     return $ek_reservedArea->get_booking_days($user);
}

add_shortcode('ek_reservedArea_get_days', 'reservedArea_days_shortcode'); 

function reservedArea_reservations_shortcode($atts) {
     extract(shortcode_atts(array(
          'user' => false,
     ), $atts));

     global $ek_reservedArea;
     return $ek_reservedArea->get_reservations($user);
}

add_shortcode('ek_reservedArea_get_reservarions', 'reservedArea_reservations_shortcode'); 


// Funzione per ridurre un numero a un singolo digit
function sum_digits_to_single($num) {
     while ($num > 9) {
         $num = array_sum(str_split($num));
     }
     return $num;
 }


// per il calcolo delle missioni
function sum_digits_to_single_special($num) {
     $is_initially_greater_than_9 = $num > 9;
 
     // Esegue la somma delle cifre fino alla riduzione a un unico numero
     while ($num > 9) {
         $num = array_sum(str_split($num));
     }
     
     // Se il numero iniziale era maggiore di 9, restituisci il numero con segno negativo
     return $is_initially_greater_than_9 ? -$num : $num;
 }


//FUNZIONI DI CALCOLO 
//somma completa data di nascita
function reduce_date_to_single_digit_details($date) {
     // Estrae giorno, mese e anno dalla stringa di data
     $parts = explode('/', $date);
     if (count($parts) != 3) {
         return false; // Ritorna false se il formato della data non è corretto
     }
 
     // Assegna giorno, mese e anno correttamente
     $day = intval($parts[0]);
     $month = intval($parts[1]);
     $year = intval($parts[2]);
 
     // Calcola le somme ridotte per giorno, mese e anno
     $day_sum = sum_digits_to_single($day);
     $month_sum = sum_digits_to_single($month);
     $year_sum = sum_digits_to_single($year);
 
     // Calcola il totale e le differenze richieste
     $total_sum = sum_digits_to_single($year_sum + $month_sum + $day_sum);
     $anno_meno_mese = $year_sum - $month_sum;
     $mese_meno_giorno = $month_sum - $day_sum;
 
     // Restituisce l'array con i risultati
     return array(
         'totale' => $total_sum, //anima
         'giorno' => $day_sum, //ego
         'mese' => $month_sum, //famiglia
         'anno' => $year_sum, //società
         'anno-meno-mese' => $anno_meno_mese, //cuore/blocco
         'mese-meno-giorno' => $mese_meno_giorno, //punto di debolezza
     );
 }
 
 function other_details($data_nascita_utente, $data_di_nascita_madre, $data_di_nascita_padre) {
     // Calcola i risultati per l'utente
     $utente_result = reduce_date_to_single_digit_details($data_nascita_utente);
     
     // Calcola i risultati per la madre, se fornita
     $madre_result = $data_di_nascita_madre ? reduce_date_to_single_digit_details($data_di_nascita_madre) : false;
     
     // Calcola i risultati per il padre, se fornita
     $padre_result = $data_di_nascita_padre ? reduce_date_to_single_digit_details($data_di_nascita_padre) : false;
 
     // Costruisci l'array di ritorno con controlli per madre e padre
     return array(
         // Se la data della madre è disponibile, esegui il calcolo; altrimenti, imposta a false //BISOGNO
         'u-giorno-meno-m-totale' => $madre_result ? sum_digits_to_single($utente_result['giorno'] - $madre_result['totale']) : false,
         
         // Se la data del padre è disponibile, esegui il calcolo; altrimenti, imposta a false //RICONOSCIMENTO
         'p-totale-piu-u-totale'  => $padre_result ? sum_digits_to_single_special($padre_result['totale'] + $utente_result['totale']) : false,
         
         // Calcolo tra il totale utente e l'anno utente, sempre eseguibile //PUNTO DI FORZA
         'u-totale-piu-u-anni'    => sum_digits_to_single_special($utente_result['totale'] + $utente_result['anno']),
         
         // Placeholder per eventuali altri calcoli (da completare)
         'comi' => get_corrispondente($utente_result['totale'],'karma'), //KARMA utente totale anima 
         'cogi' => get_corrispondente($utente_result['giorno'],'maestro'), //MAESTRO blocco maestro estratto dal karma che è la somma dell'utente giorno 
     );
 }
 




/*
UZKAH (FUOCO) 1  -> BEATRIX (SEME) 4
ISA (GELSA) 2 -> JASMINE (ALBERO) 6
GEHONIA (ANELLI) 3 -> PEHONYA (ACQUA) 7
FRESIA (FIORE) 5 -> LAK (PARASSITA) 8
FARA (SABOTATORE) 9 -> UZKAH (FUOCO) 1 
*/
 function get_corrispondente($number,$who = 'karma') {
     $corrispondente = 0;
     if($who == 'karma'):
          switch ($number) {
               case 1:
                    $corrispondente = 4;
                    break;
               case 2:
                    $corrispondente = 6;
                    break;
               case 3:
                    $corrispondente = 7;
                    break;
               case 4:
                    $corrispondente = 1;
                    break;
               case 5:
                    $corrispondente = 8;
                    break;
               /*case 6:
                    $corrispondente = 8;
                    break; */
               case 6:
                    $corrispondente = 2;
                    break; 
               case 7:
                    $corrispondente = 3;
                    break; 
               case 8:
                    $corrispondente = 5;
                    break; 
               case 9:
                    $corrispondente = 1;
                    break; 
               default:
                    $corrispondente = 1;
                    break;
          }
     else:
          switch ($number) {
               case 1:
                    $corrispondente = 4;
                    break;
               case 2:
                    $corrispondente = 6;
                    break;
               case 3:
                    $corrispondente = 7;
                    break;
               case 4:
                    $corrispondente = 1;
                    break;
               case 5:
                    $corrispondente = 8;
                    break;
               case 6:
                    $corrispondente = 2;
                    break; 
               case 7:
                    $corrispondente = 3;
                    break; 
               case 8:
                    $corrispondente = 5;
                    break; 
               case 9:
                    $corrispondente = 1;
                    break; 
               default:
                    $corrispondente = 1;
                    break;
          }
     endif;
return $corrispondente;
 }

 //passo ego e recupero blocco maestro ma mi sa che è la stessa cosa di get_corrispondente... mah
/*
Ego  Maestro
1 -> 4
2 -> 6
3 -> 7
4 -> 1
5 -> 8
6 -> 2
7-> 3
8 -> 5
9 -> 1
*/
function get_blocco_maestro($number) {
     $corrispondente = 0;
     switch ($number) {
     case 1:
          $corrispondente = 4;
          break;
     case 2:
          $corrispondente = 6;
          break;
     case 3:
          $corrispondente = 7;
          break;
     case 4:
          $corrispondente = 1;
          break;
     case 5:
          $corrispondente = 8;
          break;
     case 6:
          $corrispondente = 8;
          break; 
     case 7:
          $corrispondente = 3;
          break; 
     case 8:
          $corrispondente = 5;
          break; 
     case 9:
          $corrispondente = 1;
          break; 
     default:
          $corrispondente = 1;
          break;
     }
     return $blocco_maestro;
}




 // Funzione per aggiungere il metabox nel backend
function add_download_link_metabox() {
     add_meta_box(
         'mappa_download_link',          // ID del metabox
         __('Download Mappa Talenti', 'textdomain'), // Titolo del metabox
         'render_download_link_metabox', // Callback per la visualizzazione del metabox
         'mappa',                        // Post type
         'side',                         // Posizione
         'high'                          // Priorità
     );
 }
 
 // Callback per la visualizzazione del metabox
function render_download_link_metabox($post) {
     $download_link = do_shortcode('[e2pdf-download id="1" dataset="' . $post->ID . '"]');
     echo '<p>' . __('Scarica la mappa generata:', 'textdomain') . '</p>';
     echo $download_link;
 }
 
 // Hook per aggiungere il metabox
 add_action('add_meta_boxes', 'add_download_link_metabox');



//restituisco una array con la soluzione della mappa 
function get_solution($slug_mappa,$lingua,$utente_result,$madre_result,$padre_result,$other_result) {

/*
UTENTE
Array
(
    [totale] => MISSIONE
    [giorno] => EGO
    [mese] => FAMIGLIA
    [anno] => SOCIETA
    [anno-meno-mese] => CUORE BLOCCO
    [mese-meno-giorno] => DEBOLEZZA
)
MADRE
Array
(
    [totale] => EREDITA MADRE
    [giorno] => 
    [mese] => 
    [anno] => 
    [anno-meno-mese] => 
    [mese-meno-giorno] => 
)
PADRE
Array
(
    [totale] => EREDITA_PATERNA
    [giorno] => 
    [mese] => 
    [anno] => 
    [anno-meno-mese] => 
    [mese-meno-giorno] => 
)
OTHER
Array
(
     [u-giorno-meno-m-totale] => BISOGNO
     [p-totale-piu-u-totale] => RICONOSCIMENTO
     [u-totale-piu-u-anni] => PUNTO_DI_FORZA
     [comi] => KARMA
     [cogi] => MAESTRO
)
*/
global $wpdb;
$table_name = $wpdb->prefix . 'mappe_soluzioni';

// Ordine delle entità con le chiavi associate agli array
$entity_map = [
     'KARMA' => $other_result['comi'] ?? null,
     'FAMIGLIA' => $utente_result['mese'] ?? null,
     'EGO' => $utente_result['giorno'] ?? null,
     'BISOGNO' => $other_result['u-giorno-meno-m-totale'] ?? null,
     'EREDITA_MATERNA' => $madre_result['totale'] ?? null,
     'MAESTRO' => $other_result['cogi'] ?? null,
     'RICONOSCIMENTO' => $other_result['p-totale-piu-u-totale'] ?? null,
     'PUNTO_DI_FORZA' => $other_result['u-totale-piu-u-anni'] ?? null,
     'EREDITA_PATERNA' => $padre_result['totale'] ?? null,
     'MISSIONE' => $utente_result['totale'] ?? null,
     'CUORE' => $utente_result['anno-meno-mese'] ?? null
];

// Array per i risultati finali
$solution = [];

// Ciclo per ciascun `slug_entita` e gestione delle query
foreach ($entity_map as $slug_entita => $punteggio) {
    // Query per la domanda (senza punteggio)
    $question_query = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT slug_entita, punteggio, domanda, lingua FROM $table_name WHERE slug_mappa = %s AND slug_entita = %s AND lingua = %s AND domanda IS NOT NULL",
            $slug_mappa, $slug_entita, $lingua
        ),
        ARRAY_A
    );

    if ($question_query) {
        $solution[] = [
            'slug_entita' => $question_query['slug_entita'],
            'punteggio' => 0, // Non serve un punteggio per la domanda
            'domanda' => $question_query['domanda'],
            'lingua' => $question_query['lingua']
        ];
    }

    // Query per la risposta (con punteggio)
    if (is_numeric($punteggio)) {
        $answer_query = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT slug_entita, punteggio, risposta, lingua FROM $table_name WHERE slug_mappa = %s AND slug_entita = %s AND lingua = %s AND punteggio = %d AND risposta IS NOT NULL",
                $slug_mappa, $slug_entita, $lingua, intval($punteggio)
            ),
            ARRAY_A
        );

        if ($answer_query) {
            $solution[] = [
                'slug_entita' => $answer_query['slug_entita'],
                'punteggio' => $punteggio,
                'risposta' => $answer_query['risposta'],
                'lingua' => $answer_query['lingua']
            ];
        }

    }

}
return $solution;
}
 

function convert_date_shortcode($atts, $content = null) {
     // Recupera la data passata come contenuto dello shortcode
     $date_string = do_shortcode($content); // Valuta il contenuto come uno shortcode, se necessario
 
     // Verifica il formato della data e convertila
     if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_string)) {
         // Formato YYYY-MM-DD
         $date_parts = explode('-', $date_string); // Divide anno, mese, giorno
         $formatted_date = $date_parts[2] . '/' . $date_parts[1] . '/' . $date_parts[0]; // Ricostruisce la data
         return $formatted_date;
     } elseif (preg_match('/^\d{8}$/', $date_string)) {
         // Formato compatto YYYYMMDD
         $year = substr($date_string, 0, 4);
         $month = substr($date_string, 4, 2);
         $day = substr($date_string, 6, 2);
         $formatted_date = $day . '/' . $month . '/' . $year; // Ricostruisce la data
         return $formatted_date;
     } else {
         return 'Formato data non valido. Usa il formato YYYY-MM-DD o YYYYMMDD.';
     }
 }
 
 // Registra lo shortcode [convert_date]
 add_shortcode('convert_date', 'convert_date_shortcode');
 



 function acf_field_by_language_shortcode($atts, $content = null) {
     // Recupera il valore restituito dallo shortcode interno
     $language = do_shortcode($content); // Questo esegue lo shortcode interno, ad esempio [get_language]
     
     // Definisci i campi ACF da utilizzare
     $fields = array(
         'ITA' => 'immagine_mappa_talenti_it',
         'EN' => 'immagine_mappa_talenti_en',
     );
     
     // Controlla se la lingua è valida e il campo esiste
     if (isset($fields[$language])) {
         // Ottieni il valore del campo ACF globale (option)
         $acf_field_value = get_field($fields[$language], 'option'); // Usa il gruppo globale "option"
         
         // Se il campo ha un valore, restituiscilo
         if ($acf_field_value) {
             return $acf_field_value;
         } else {
             return 'Il campo ACF "' . esc_html($fields[$language]) . '" non contiene dati.';
         }
     } else {
         return 'Lingua non valida. Usa ITA o EN.';
     }
 }
 
 // Registra lo shortcode [acf_field_by_language]
 add_shortcode('acf_field_by_language', 'acf_field_by_language_shortcode');
 