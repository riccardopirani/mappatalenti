<?php

/**
 * classe principale starter plugin
 **/
namespace map_plugin;

class Mastermap
{

    const VERSIONE = '1.0';

    function __construct()
    {
        add_action('init', array($this, 'handle_map_registration')); //aggiungo registrazione
    }
    //lo chiamo nello shortcode in functions
    public function form_mappa_talenti($slug_mappa = '', $lingua = '')
    {

        if ($lingua == 'EN'):
            $form = '<form id="f_mappa_talenti" action="' . $_SERVER['REQUEST_URI'] . '" method="post" onsubmit="return handleSubmit();">';
            $form .= '<p><b>*</b> Fill in the required fields</p>';

            // campi che indicano la mappa di riferimento e la lingua
            $form .= '<input type="hidden" name="slug_mappa" value="' . esc_attr($slug_mappa) . '">';
            $form .= '<input type="hidden" name="lingua" value="' . esc_attr($lingua) . '">';
            $form .= '<div class="row reg-row my-1">';
            $form .= '<div class="col-md-3 mb-2">';
            $form .= '<label for="nome">Name*</label>';
            $form .= '<input class="form-control" type="text" name="nome" required placeholder="Nome*">';
            $form .= '</div>';
            $form .= '<div class="col-md-3 mb-2">';
            $form .= '<label for="cognome">Last Name*</label>';
            $form .= '<input class="form-control" type="text" name="cognome" required placeholder="Cognome*">';
            $form .= '</div>';
            $form .= '<div class="col-md-3 mb-2">';
            $form .= '<label for="email">E-mail*</label>';
            $form .= '<input class="form-control" type="email" name="email" required placeholder="E-mail*">';
            $form .= '</div>';
            $form .= '<div class="col-md-3 mb-2">';
            $form .= '<label for="sesso">Gender*</label><br>';
            $form .= '<div class="form-check form-check-inline">';
            $form .= '<input class="form-check-input" type="radio" name="sesso" id="uomo" value="uomo" required>';
            $form .= '<label class="form-check-label" for="uomo">Male</label>';
            $form .= '</div>';
            $form .= '<div class="form-check form-check-inline">';
            $form .= '<input class="form-check-input" type="radio" name="sesso" id="donna" value="donna" required>';
            $form .= '<label class="form-check-label" for="donna">Female</label>';
            $form .= '</div>';
            $form .= '</div>';
            $form .= '<div class="col-md-4 mb-2">';
            $form .= '<label for="data_nascita_utente">Your date of birth*</label>';
            $form .= '<input class="form-control" type="text" id="data_di_nascita_utente" name="data_di_nascita_utente" required placeholder="gg/mm/aaaa" pattern="\d{1,2}/\d{1,2}/\d{4}">';

            $form .= '</div>';
            $form .= '<div class="col-md-4 mb-2">';
            $form .= '<label for="data_di_nascita_madre">Your mother\'s date of birth</label>';
            $form .= '<input class="form-control" type="text"  id="data_di_nascita_madre" name="data_di_nascita_madre" placeholder="gg/mm/aaaa" pattern="\d{1,2}/\d{1,2}/\d{4}">';
            $form .= '</div>';
            $form .= '<div class="col-md-4 mb-2">';
            $form .= '<label for="data_di_nascita_padre">Your father\'s date of birth</label>';
            $form .= '<input class="form-control" type="text" id="data_di_nascita_padre" name="data_di_nascita_padre" placeholder="gg/mm/aaaa" pattern="\d{1,2}/\d{1,2}/\d{4}">';
            $form .= '</div>';
            $form .= '<div class="col-md-12 mb-2 ps-5 form-check">';
            $form .= '<input class="form-check-input" type="checkbox" name="accettazione_privacy" required>';
            $form .= ' <label class="form-check-label" for="accettazione_privacy">I have read the <a href="#">privacy policy</a> and I consent to the storage of my data, in accordance with the European regulation on personal data protection no. 679/2016 (GDPR)*</label>';
            $form .= '</div>';
            $form .= '<div class="col-md-12 mb-2">';
            $form .= '<input type="submit" name="book" value="SEND" class="btn btn-primary"/>';
            $form .= '</div>';
            $form .= '</div>';
            $form .= '</form>';

        else:
            $form = '<form id="f_mappa_talenti" action="' . $_SERVER['REQUEST_URI'] . '" method="post" onsubmit="return handleSubmit();">';
            $form .= '<p><b>*</b> Compila i campi richiesti</p>';
            // campi che indicano la mappa di riferimento e la lingua
            $form .= '<input type="hidden" name="slug_mappa" value="' . esc_attr($slug_mappa) . '">';
            $form .= '<input type="hidden" name="lingua" value="' . esc_attr($lingua) . '">';
            $form .= '<div class="row reg-row my-1">';
            $form .= '<div class="col-md-3 mb-2">';
            $form .= '<label for="nome">' . __('Nome', 'ek_mappa') . '*</label>';
            $form .= '<input class="form-control" type="text" name="nome" required placeholder="Nome*">';
            $form .= '</div>';
            $form .= '<div class="col-md-3 mb-2">';
            $form .= '<label for="cognome">' . __('Cognome', 'ek_mappa') . '*</label>';
            $form .= '<input class="form-control" type="text" name="cognome" required placeholder="Cognome*">';
            $form .= '</div>';
            $form .= '<div class="col-md-3 mb-2">';
            $form .= '<label for="email">' . __('E-mail', 'ek_mappa') . '*</label>';
            $form .= '<input class="form-control" type="email" name="email" required placeholder="E-mail*">';
            $form .= '</div>';
            $form .= '<div class="col-md-3 mb-2">';
            $form .= '<label for="sesso">' . __('Sesso', 'ek_mappa') . '*</label><br>';
            $form .= '<div class="form-check form-check-inline">';
            $form .= '<input class="form-check-input" type="radio" name="sesso" id="uomo" value="uomo" required>';
            $form .= '<label class="form-check-label" for="uomo">' . __('Uomo', 'ek_mappa') . '</label>';
            $form .= '</div>';
            $form .= '<div class="form-check form-check-inline">';
            $form .= '<input class="form-check-input" type="radio" name="sesso" id="donna" value="donna" required>';
            $form .= '<label class="form-check-label" for="donna">' . __('Donna', 'ek_mappa') . '</label>';
            $form .= '</div>';
            $form .= '</div>';
            $form .= '<div class="col-md-4 mb-2">';
            $form .= '<label for="data_nascita_utente">' . __('La tua data di nascita', 'ek_mappa') . '*</label>';
            //$form .= '<input class="form-control" type="date" name="data_di_nascita_utente" required>';
            $form .= '<input class="form-control" type="text" id="data_di_nascita_utente" name="data_di_nascita_utente" required placeholder="gg/mm/aaaa" pattern="\d{1,2}/\d{1,2}/\d{4}">';

            $form .= '</div>';
            $form .= '<div class="col-md-4 mb-2">';
            $form .= '<label for="data_di_nascita_madre">' . __('Data di nascita di tua madre', 'ek_mappa') . '</label>';
            //$form .= '<input class="form-control" type="date" name="data_di_nascita_madre" required>';
            $form .= '<input class="form-control" type="text"  id="data_di_nascita_madre" name="data_di_nascita_madre" placeholder="gg/mm/aaaa" pattern="\d{1,2}/\d{1,2}/\d{4}">';
            $form .= '</div>';
            $form .= '<div class="col-md-4 mb-2">';
            $form .= '<label for="data_di_nascita_padre">' . __('Data di nascita di tuo padre', 'ek_mappa') . '</label>';
            //$form .= '<input class="form-control" type="date" name="data_di_nascita_padre" required>';
            $form .= '<input class="form-control" type="text" id="data_di_nascita_padre" name="data_di_nascita_padre" placeholder="gg/mm/aaaa" pattern="\d{1,2}/\d{1,2}/\d{4}">';
            $form .= '</div>';
            $form .= '<div class="col-md-12 mb-2 ps-5 form-check">';
            $form .= '<input class="form-check-input" type="checkbox" name="accettazione_privacy" required>';
            $form .= ' <label class="form-check-label" for="accettazione_privacy">Ho letto l\'<a href="#">informativa sulla privacy</a> e acconsento alla memorizzazione dei miei dati, secondo quanto stabilito dal regolamento europeo per la protezione dei dati personali n. 679/2016 (GDPR)*</label>';
            $form .= '</div>';
            $form .= '<div class="col-md-12 mb-2">';
            $form .= '<input type="submit" name="book" value="' . __('INVIA', 'ek_mappa') . '" class="btn btn-primary"/>';
            $form .= '</div>';
            $form .= '</div>';
            $form .= '</form>';
        endif;

        $form .= '<script>';
        $form .= 'function handleSubmit() {';
        $form .= '    var submitButton = document.getElementById("submit_button");';
        $form .= '    submitButton.disabled = true;';
        $form .= '    submitButton.value = "Invio in corso...";';
        $form .= '    return true;';
        $form .= '}';

        // Funzione per aggiungere gli slash automatici
        $form .= 'function addDateSlashes(inputId) {';
        $form .= '    document.getElementById(inputId).addEventListener("input", function(e) {';
        $form .= '        var value = e.target.value;';
        $form .= '        value = value.replace(/\D/g, "");';

        $form .= '        if (value.length > 2 && value.length <= 4) {';
        $form .= '            value = value.slice(0, 2) + "/" + value.slice(2);';
        $form .= '        } else if (value.length > 4) {';
        $form .= '            value = value.slice(0, 2) + "/" + value.slice(2, 4) + "/" + value.slice(4, 8);';
        $form .= '        }';

        $form .= '        e.target.value = value;';
        $form .= '    });';
        $form .= '}';

        // Applica la funzione a tutti i campi data
        $form .= 'addDateSlashes("data_di_nascita_utente");';
        $form .= 'addDateSlashes("data_di_nascita_madre");';
        $form .= 'addDateSlashes("data_di_nascita_padre");';

        $form .= '</script>';
        return $form;
    }



    public function handle_map_registration()
    {
        session_start();
        // Verifica se il form è stato inviato tramite POST e il campo 'book' è settato
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book'])) {

            // Previene il doppio invio controllando una variabile di sessione
            if (isset($_SESSION['last_submit']) && (time() - $_SESSION['last_submit']) < 30) {
                echo '<p>Stai inviando troppo rapidamente. Attendere un momento.</p>';
                return;
            }
            $_SESSION['last_submit'] = time();

            // Prepara i dati dal form
            $nome = sanitize_text_field($_POST['nome']);
            $cognome = sanitize_text_field($_POST['cognome']);
            $email = sanitize_email($_POST['email']);
            $sesso = sanitize_text_field($_POST['sesso']);

            $slug_mappa = sanitize_text_field($_POST['slug_mappa']);
            $lingua = sanitize_text_field($_POST['lingua']);

            $data_nascita_utente = sanitize_text_field($_POST['data_di_nascita_utente']);
            $data_di_nascita_madre = sanitize_text_field($_POST['data_di_nascita_madre']);
            $data_di_nascita_padre = sanitize_text_field($_POST['data_di_nascita_padre']);
            $accettazione_privacy = sanitize_text_field($_POST['accettazione_privacy']);

            $utente_result = reduce_date_to_single_digit_details($data_nascita_utente);
            $madre_result = reduce_date_to_single_digit_details($data_di_nascita_madre);
            $padre_result = reduce_date_to_single_digit_details($data_di_nascita_padre);
            $other_result = other_details($data_nascita_utente, $data_di_nascita_madre, $data_di_nascita_padre);

            $solution = get_solution($slug_mappa, $lingua, $utente_result, $madre_result, $padre_result, $other_result);



            // Formatta il titolo del nuovo post
            $post_title = "Mappa Talenti: " . $nome . " " . $cognome;

            // Prepara il post da inserire nel custom post type "mappa"
            $post_data = array(
                'post_title' => $post_title,
                'post_type' => 'mappa',  // Specifica il custom post type
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
            );

            // Inserisci il post
            $post_id = wp_insert_post($post_data);

            // Controlla se il post è stato creato correttamente
            if ($post_id != 0) {
                // Imposta i campi ACF con i valori corrispondenti
                update_field('nome', strtoupper($nome), $post_id);
                update_field('cognome', strtoupper($cognome), $post_id);
                update_field('sesso', $sesso, $post_id);
                update_field('email', $email, $post_id);

                $date_object = \DateTime::createFromFormat('d/m/Y', $data_nascita_utente);
                if ($data_nascita_utente !== false) {
                    $data_nascita_utente = $date_object->format('Y-m-d');
                    update_field('data_di_nascita_utente', $data_nascita_utente, $post_id);
                }

                $date_object = \DateTime::createFromFormat('d/m/Y', $data_di_nascita_madre);
                if ($data_di_nascita_madre !== false) {
                    $data_di_nascita_madre = $date_object->format('Y-m-d');
                    update_field('data_di_nascita_madre', $data_di_nascita_madre, $post_id);
                }

                $date_object = \DateTime::createFromFormat('d/m/Y', $data_di_nascita_padre);
                if ($data_di_nascita_padre !== false) {
                    $data_di_nascita_padre = $date_object->format('Y-m-d');
                    update_field('data_di_nascita_padre', $data_di_nascita_padre, $post_id);
                }

                update_field('lingua', $lingua, $post_id);
                update_field('slug_mappa', $slug_mappa, $post_id);

                update_field('utente_totale', $utente_result['totale'], $post_id);
                update_field('madre_totale', $madre_result['totale'], $post_id);
                update_field('padre_totale', $padre_result['totale'], $post_id);

                update_field('utente_anno', $utente_result['anno'], $post_id);
                update_field('madre_anno', $madre_result['anno'], $post_id);
                update_field('padre_anno', $padre_result['anno'], $post_id);

                update_field('utente_mese', $utente_result['mese'], $post_id);
                update_field('madre_mese', $madre_result['mese'], $post_id);
                update_field('padre_mese', $padre_result['mese'], $post_id);

                update_field('utente_giorno', $utente_result['giorno'], $post_id);
                update_field('madre_giorno', $madre_result['giorno'], $post_id);
                update_field('padre_giorno', $padre_result['giorno'], $post_id);

                update_field('u-anno-meno-u-mese', $utente_result['anno-meno-mese'], $post_id);      //pos 6      
                update_field('u-mese-meno-u-giorno', $utente_result['mese-meno-giorno'], $post_id);      //pos 10

                update_field('u-giorno-meno-m-totale', $other_result['u-giorno-meno-m-totale'], $post_id);      //pos 11
                update_field('p-totale-piu-u-totale', $other_result['p-totale-piu-u-totale'], $post_id);      //pos 12
                update_field('u-totale-piu-u-anni', $other_result['u-totale-piu-u-anni'], $post_id);      //pos 13
                update_field('comi', $other_result['comi'], $post_id);      //pos 13 KARMA
                update_field('cogi', $other_result['cogi'], $post_id);      //pos 13 Maestro

                update_field('accettazione_privacy', $accettazione_privacy, $post_id);

                // Genera il link di download usando lo shortcode
                $download_link = do_shortcode('[e2pdf-download id="1" dataset="' . $post_id . '"]');
                $download_url = do_shortcode('[e2pdf-download id="1" output="url" dataset="' . $post_id . '"]');
                $data_di_nascita_madre_txt = ($data_di_nascita_madre) ? $data_di_nascita_madre : 'data non inserita';
                $data_di_nascita_padre_txt = ($data_di_nascita_padre) ? $data_di_nascita_padre : 'data non inserita';


                //prendo i campi nella giusta lingua
                if ($lingua == 'EN'):
                    $oggetto_email = get_field('oggetto_email_en', 'option');
                    $corpo_email = get_field('corpo_email_en', 'option');
                    $footer_email = get_field('footer_email_en', 'option');
                    $label_punteggio = 'Score obtained';
                    $label_risultati = 'This is the interpretation of your map';
                    $label_download = 'To download your map';
                else:
                    $oggetto_email = get_field('oggetto_email', 'option');
                    $corpo_email = get_field('corpo_email', 'option');
                    $footer_email = get_field('footer_email', 'option');
                    $label_punteggio = 'Punteggio ottenuto';
                    $label_risultati = 'Questa è l\'interpretazione della tua mappa';
                    $label_download = 'Per scaricare la tua mappa';
                endif;

                global $wpdb;

                // Variabile per la lingua corrente (ad esempio 'EN' o 'ITA')
                $lingua_corrente = ($lingua === 'EN') ? 'EN' : 'ITA';

                // Query per ottenere tutte le etichette corrispondenti alla lingua corrente
                $etichette = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT slug_mappa_et, etichetta 
         FROM wp_mappe_etichette 
         WHERE lingua_et = %s",
                        $lingua_corrente
                    ),
                    ARRAY_A
                );

                // Organizza le etichette in un array associativo per un accesso rapido
                $etichette_map = [];
                foreach ($etichette as $etichetta) {
                    $etichette_map[$etichetta['slug_mappa_et']] = $etichetta['etichetta'];
                }


                // Costruisci il contenuto della soluzione da inserire nell'email
                $solution_content = '<h3>' . $label_risultati . ':</h3>';
                foreach ($solution as $item) {
                    if (isset($item['domanda'])) {
                        // Aggiungi il nome dell'entità (sostituendo lo slug con l'etichetta, se esiste)
                        $nome_entita = isset($etichette_map[$item['slug_entita']])
                            ? $etichette_map[$item['slug_entita']]
                            : $item['slug_entita']; // Usa lo slug come fallback

                        $solution_content .= '<h3 style="background-color: #eee;padding: 3px 12px; margin-bottom:0">' . esc_html($nome_entita) . '</h3>';
                        $solution_content .= '<p style="padding:3px 6px; border:1px solid #eee; margin-bottom:0"><strong>' . esc_html($item['domanda']) . '</strong><br>';
                    }
                    if (isset($item['risposta'])) {
                        // Aggiungi il punteggio e la risposta
                        $solution_content .= '<strong>' . $label_punteggio . ': ' . esc_html($item['punteggio']) . '</strong><br>';
                        $solution_content .= esc_html($item['risposta']) . '</p><br>';
                    }
                }


                //se c'è un oggetto impostato usiamo quello
                $subject_user = (get_field('oggetto_email', 'option')) ? get_field('oggetto_email', 'option') : "Riepilogo Mappa Talenti";



                // Costruisci il messaggio HTML dell'email
                $message_user = '<!doctype html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>' . $subject_user . '</title>
    <style media="all" type="text/css">
        body {
            font-family: Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 16px;
            line-height: 1.3;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            background-color: #f4f5f6;
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 0 auto;
            max-width: 600px;
            padding: 24px;
            width: 100%;
        }
        .main {
            background: #ffffff;
            border: 1px solid #eaebed;
            border-radius: 16px;
            width: 100%;
            padding: 24px;
        }
        p {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
            margin: 0;
            margin-bottom: 16px;
        }
        a {
            color: #0867ec;
            text-decoration: underline;
        }
        .dwnButton a {
            font-size:16px;
        }

        .footer {
            text-align: center;
            color: #9a9ea6;
            font-size: 16px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Inizio Contenuto Email -->
        <div class="main">
            <!-- Testata Email -->
            ' . ((get_field('testata_email', 'option')) ? "<img style='width:100%; height:auto; display:block; margin-bottom:20px;' src='" . get_field('testata_email', 'option') . "'>" : '') . '
            
            <!-- Corpo Email -->
            ' . (($corpo_email) ? $corpo_email : "<h1 style='font-size:18px'>Grazie per aver compilato la Mappa Talenti</h1>") . '
            
            ' . $solution_content . ' <!-- Aggiungi qui il contenuto della soluzione -->
            <p style="padding:3px 6px; border:1px solid #eee; margin-bottom:0; margin-top:10px"><b>' . $label_download . '</b><br>
            <span class="dwnButton">' . $download_link . '</span></p>
        </div>
        <!-- Fine Contenuto Email -->

        <!-- Footer -->
        ' . ($footer_email ? '<div class="footer"><p>' . $footer_email . '</p></div>' : '') . '
    </div>
</body>
</html>';


                // Aggiungi header per l'email HTML
                $headers = array('Content-Type: text/html; charset=UTF-8');

                // Invia l'email
                wp_mail($email, $subject_user, $message_user, $headers);

                // Inviare email di riepilogo all'amministratore
                $admin_email = (get_field('email_notifica_compilazione', 'option')) ? get_field('email_notifica_compilazione', 'option') : "alessandro@eklettica.it";
                $subject_admin = "Nuova Mappa Talenti Creata";
                $message_admin = "Un utente ha creato una nuova Mappa Talenti.\n\n";
                $message_admin .= "Nome: " . $nome . "\n";
                $message_admin .= "Cognome: " . $cognome . "\n";
                $message_admin .= "E-mail: " . $email . "\n";
                $message_admin .= "Sesso: " . $sesso . "\n";
                $message_admin .= "Data di nascita: " . $data_nascita_utente . "\n";
                $message_admin .= "Data di nascita madre: " . $data_di_nascita_madre_txt . "\n";
                $message_admin .= "Data di nascita padre: " . $data_di_nascita_padre_txt . "\n\n";
                $message_admin .= "Scarica la mappa da qui: " . $download_link . "\n";
                wp_mail($admin_email, $subject_admin, $message_admin);

                if ($lingua == 'EN'):
                    $pagina_conferma = get_field('pagina_conferma_en', 'option');
                else:
                    $pagina_conferma = get_field('pagina_conferma_it', 'option');
                endif;

                // Redirigi alla pagina con ID 99
                wp_redirect($pagina_conferma);
                exit; // Assicurati che il redirect avvenga subito

            } else {
                // Gestisci l'errore nella creazione del post
                echo '<p>Errore nella creazione della mappa dei talenti.</p>';
            }
        }
    }





    public function handle_map_registration_old()
    {
        session_start();
        // Verifica se il form è stato inviato tramite POST e il campo 'book' è settato
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book'])) {

            // Previene il doppio invio controllando una variabile di sessione
            if (isset($_SESSION['last_submit']) && (time() - $_SESSION['last_submit']) < 30) {
                echo '<p>Stai inviando troppo rapidamente. Attendere un momento.</p>';
                return;
            }
            $_SESSION['last_submit'] = time();

            // Prepara i dati dal form
            $nome = sanitize_text_field($_POST['nome']);
            $cognome = sanitize_text_field($_POST['cognome']);
            $email = sanitize_email($_POST['email']);
            $sesso = sanitize_text_field($_POST['sesso']);

            $slug_mappa = sanitize_text_field($_POST['slug_mappa']);
            $lingua = sanitize_text_field($_POST['lingua']);

            $data_nascita_utente = sanitize_text_field($_POST['data_di_nascita_utente']);
            $data_di_nascita_madre = sanitize_text_field($_POST['data_di_nascita_madre']);
            $data_di_nascita_padre = sanitize_text_field($_POST['data_di_nascita_padre']);
            $accettazione_privacy = sanitize_text_field($_POST['accettazione_privacy']);

            $utente_result = reduce_date_to_single_digit_details($data_nascita_utente);
            $madre_result = reduce_date_to_single_digit_details($data_di_nascita_madre);
            $padre_result = reduce_date_to_single_digit_details($data_di_nascita_padre);
            $other_result = other_details($data_nascita_utente, $data_di_nascita_madre, $data_di_nascita_padre);

            $solution = get_solution($slug_mappa, $lingua, $utente_result, $madre_result, $padre_result, $other_result);



            // Formatta il titolo del nuovo post
            $post_title = "Mappa Talenti: " . $nome . " " . $cognome;

            // Prepara il post da inserire nel custom post type "mappa"
            $post_data = array(
                'post_title' => $post_title,
                'post_type' => 'mappa',  // Specifica il custom post type
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
            );

            // Inserisci il post
            $post_id = wp_insert_post($post_data);

            // Controlla se il post è stato creato correttamente
            if ($post_id != 0) {
                // Imposta i campi ACF con i valori corrispondenti
                update_field('nome', strtoupper($nome), $post_id);
                update_field('cognome', strtoupper($cognome), $post_id);
                update_field('sesso', $sesso, $post_id);
                update_field('email', $email, $post_id);

                $date_object = DateTime::createFromFormat('d/m/Y', $data_nascita_utente);
                if ($data_nascita_utente !== false) {
                    $data_nascita_utente = $date_object->format('Y-m-d');
                    update_field('data_di_nascita_utente', $data_nascita_utente, $post_id);
                }

                $date_object = DateTime::createFromFormat('d/m/Y', $data_di_nascita_madre);
                if ($data_di_nascita_madre !== false) {
                    $data_di_nascita_madre = $date_object->format('Y-m-d');
                    update_field('data_di_nascita_madre', $data_di_nascita_madre, $post_id);
                }

                $date_object = DateTime::createFromFormat('d/m/Y', $data_di_nascita_padre);
                if ($data_di_nascita_padre !== false) {
                    $data_di_nascita_padre = $date_object->format('Y-m-d');
                    update_field('data_di_nascita_padre', $data_di_nascita_padre, $post_id);
                }

                update_field('utente_totale', $utente_result['totale'], $post_id);
                update_field('madre_totale', $madre_result['totale'], $post_id);
                update_field('padre_totale', $padre_result['totale'], $post_id);

                update_field('utente_anno', $utente_result['anno'], $post_id);
                update_field('madre_anno', $madre_result['anno'], $post_id);
                update_field('padre_anno', $padre_result['anno'], $post_id);

                update_field('utente_mese', $utente_result['mese'], $post_id);
                update_field('madre_mese', $madre_result['mese'], $post_id);
                update_field('padre_mese', $padre_result['mese'], $post_id);

                update_field('utente_giorno', $utente_result['giorno'], $post_id);
                update_field('madre_giorno', $madre_result['giorno'], $post_id);
                update_field('padre_giorno', $padre_result['giorno'], $post_id);

                update_field('u-anno-meno-u-mese', $utente_result['anno-meno-mese'], $post_id);      //pos 6      
                update_field('u-mese-meno-u-giorno', $utente_result['mese-meno-giorno'], $post_id);      //pos 10

                update_field('u-giorno-meno-m-totale', $other_result['u-giorno-meno-m-totale'], $post_id);      //pos 11
                update_field('p-totale-piu-u-totale', $other_result['p-totale-piu-u-totale'], $post_id);      //pos 12
                update_field('u-totale-piu-u-anni', $other_result['u-totale-piu-u-anni'], $post_id);      //pos 13
                update_field('comi', $other_result['comi'], $post_id);      //pos 13 KARMA
                update_field('cogi', $other_result['cogi'], $post_id);      //pos 13 Maestro

                update_field('accettazione_privacy', $accettazione_privacy, $post_id);

                // Genera il link di download usando lo shortcode
                $download_link = do_shortcode('[e2pdf-download id="2" dataset="' . $post_id . '"]');
                $download_url = do_shortcode('[e2pdf-download id="2" output="url" dataset="' . $post_id . '"]');
                $data_di_nascita_madre_txt = ($data_di_nascita_madre) ? $data_di_nascita_madre : 'data non inserita';
                $data_di_nascita_padre_txt = ($data_di_nascita_padre) ? $data_di_nascita_padre : 'data non inserita';



                //se c'è un oggetto impostato usiamo quello
                $subject_user = (get_field('oggetto_email', 'option')) ? get_field('oggetto_email', 'option') : "Riepilogo Mappa Talenti";

                // Costruisci il messaggio HTML dell'email
                $message_user = '<!doctype html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>' . $subject_user . '</title>
    <style media="all" type="text/css">
        body {
            font-family: Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 16px;
            line-height: 1.3;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            background-color: #f4f5f6;
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 0 auto;
            max-width: 600px;
            padding: 24px;
            width: 100%;
        }
        .main {
            background: #ffffff;
            border: 1px solid #eaebed;
            border-radius: 16px;
            width: 100%;
            padding: 24px;
        }
        p {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
            margin: 0;
            margin-bottom: 16px;
        }
        a {
            color: #0867ec;
            text-decoration: underline;
        }
        .footer {
            text-align: center;
            color: #9a9ea6;
            font-size: 16px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Inizio Contenuto Email -->
        <div class="main">
            <!-- Testata Email -->
            ' . ((get_field('testata_email', 'option')) ? "<img style='width:100%; height:auto; display:block; margin-bottom:20px;' src='" . get_field('testata_email', 'option') . "'>" : '') . '
            
            <!-- Corpo Email -->
            ' . ((get_field('corpo_email', 'option')) ? get_field('corpo_email', 'option') : "<h1 style='font-size:18px'>Grazie per aver compilato la Mappa Talenti</h1>") . '
            
            <p><b>' . $download_link . '</b></p>
        </div>
        <!-- Fine Contenuto Email -->

        <!-- Footer -->
        ' . (get_field('footer_email', 'option') ? '<div class="footer"><p>' . get_field('footer_email', 'option') . '</p></div>' : '') . '
    </div>
</body>
</html>';


                // Aggiungi header per l'email HTML
                $headers = array('Content-Type: text/html; charset=UTF-8');

                // Invia l'email
                wp_mail($email, $subject_user, $message_user, $headers);









                // Inviare email di riepilogo all'amministratore
                $admin_email = (get_field('email_notifica_compilazione', 'option')) ? get_field('email_notifica_compilazione', 'option') : "alessandro@eklettica.it";
                $subject_admin = "Nuova Mappa Talenti Creata";
                $message_admin = "Un utente ha creato una nuova Mappa Talenti.\n\n";
                $message_admin .= "Nome: " . $nome . "\n";
                $message_admin .= "Cognome: " . $cognome . "\n";
                $message_admin .= "E-mail: " . $email . "\n";
                $message_admin .= "Sesso: " . $sesso . "\n";
                $message_admin .= "Data di nascita: " . $data_nascita_utente . "\n";
                $message_admin .= "Data di nascita madre: " . $data_di_nascita_madre_txt . "\n";
                $message_admin .= "Data di nascita padre: " . $data_di_nascita_padre_txt . "\n\n";
                $message_admin .= "Scarica la mappa da qui: " . $download_link . "\n";
                wp_mail($admin_email, $subject_admin, $message_admin);


                // Redirigi alla pagina con ID 99
                wp_redirect(get_permalink(99));
                exit; // Assicurati che il redirect avvenga subito

            } else {
                // Gestisci l'errore nella creazione del post
                echo '<p>Errore nella creazione della mappa dei talenti.</p>';
            }
        }
    }

}