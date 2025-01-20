<?php

/**
 * Classe backend gestione interfaccia e logica
 */
namespace map_plugin;

class Map_backend
{
    function __construct()
    {
        add_action('admin_menu', [$this, 'add_import_page']);
        add_action('admin_post_import_csv', [$this, 'import_csv_data']);
        add_action('admin_post_append_csv', [$this, 'append_csv_data']);
    }

    public function add_import_page()
    {
        add_menu_page(
            'Importazione Mappe', // Titolo della pagina
            'Importazione Mappe', // Titolo del menu
            'manage_options', // Capacità richiesta
            'importazione-mappe', // Slug della pagina
            [$this, 'render_import_page'], // Callback per il contenuto della pagina
            'dashicons-admin-site', // Icona del menu (puoi cambiarla a piacere)
            20 // Posizione nel menu
        );
    }

    public function render_import_page()
    {
        // Directory dei file CSV
        $directory = WP_CONTENT_DIR . '/uploads/import/';

        // Controlla se la directory esiste
        if (is_dir($directory)) {
            // Ottieni i file CSV nella directory
            $files = glob($directory . '*.csv');

            echo '<div class="wrap">';
            echo '<h1>Importazione Mappe</h1>';

            if (!empty($files)) {
                echo '<table class="widefat fixed" cellspacing="0">';
                echo '<thead><tr><th>Nome del File</th><th>Data Ultima Modifica</th><th>Importa</th><th>Appendi</th></tr></thead>';
                echo '<tbody>';

                foreach ($files as $file) {
                    $file_name = basename($file);
                    $file_mod_time = date('d-m-Y H:i:s', filemtime($file));
                    $import_link = admin_url('admin-post.php?action=import_csv&file=' . urlencode($file_name));
                    $append_link = admin_url('admin-post.php?action=append_csv&file=' . urlencode($file_name));

                    echo '<tr>';
                    echo '<td>' . esc_html($file_name) . '</td>';
                    echo '<td>' . esc_html($file_mod_time) . '</td>';
                    echo '<td><a href="' . esc_url($import_link) . '">Importa</a></td>';
                    echo '<td><a href="' . esc_url($append_link) . '">Appendi</a></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>Nessun file CSV trovato nella cartella di importazione.</p>';
            }

            echo '</div>';
        } else {
            echo '<p>La directory di importazione non esiste. Assicurati che la cartella <code>wp-content/uploads/import</code> sia presente.</p>';
        }
    }

    public function import_csv_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mappe_soluzioni';

        // Cancella il contenuto della tabella
        $wpdb->query("TRUNCATE TABLE $table_name");

        // Verifica il file CSV
        if (isset($_GET['file'])) {
            $file_name = sanitize_text_field($_GET['file']);
            $file_path = WP_CONTENT_DIR . '/uploads/import/' . $file_name;

            if (file_exists($file_path)) {
                if (($handle = fopen($file_path, 'r')) !== FALSE) {
                    // Leggi la prima riga per ottenere i nomi delle colonne
                    $headers = fgetcsv($handle, 1000, ';');
                    if ($headers) {
                        $headers = array_map(function ($header) {
                            return trim($header, '"'); // Rimuove virgolette doppie dai bordi
                        }, $headers);

                        // Rimuovi 'id_soluzione' dalle intestazioni se presente
                        $has_id_soluzione = false;
                        if (in_array('id_soluzione', $headers)) {
                            $headers = array_filter($headers, function ($header) {
                                return $header !== 'id_soluzione';
                            });
                            $has_id_soluzione = true;
                        }

                        // Assicurati che le intestazioni siano valide e presenti
                        if (count($headers) > 0) {
                            while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                                // Rimuovi virgolette doppie dai valori
                                $data = array_map(function ($value) {
                                    return trim($value, '"');
                                }, $data);

                                // Se 'id_soluzione' è stato rimosso dalle intestazioni, elimina il primo elemento dai dati
                                if ($has_id_soluzione) {
                                    array_shift($data); // Rimuove il primo elemento dai dati
                                }

                                // Verifica che la riga abbia lo stesso numero di elementi delle intestazioni
                                if (count($data) === count($headers)) {
                                    $row_data = array_combine($headers, $data);

                                    // Inserisci i dati nel database senza 'id_soluzione'
                                    $wpdb->insert(
                                        $table_name,
                                        [
                                            'slug_mappa' => sanitize_text_field($row_data['slug_mappa'] ?? ''),
                                            'slug_entita' => sanitize_text_field($row_data['slug_entita'] ?? ''),
                                            'punteggio' => intval($row_data['punteggio'] ?? 0),
                                            'domanda' => sanitize_text_field($row_data['domanda'] ?? ''),
                                            'domanda_alt_f' => sanitize_text_field($row_data['domanda_alt_f'] ?? ''),
                                            'risposta' => sanitize_text_field($row_data['risposta'] ?? ''),
                                            'risposta_alt_f' => sanitize_text_field($row_data['risposta_alt_f'] ?? ''),
                                            'lingua' => sanitize_text_field($row_data['lingua'] ?? ''),
                                        ]
                                    );
                                } else {
                                    error_log('Numero di elementi nella riga non corrisponde al numero di intestazioni. Riga: ' . implode(';', $data));
                                }
                            }
                        } else {
                            error_log('Le intestazioni del CSV non sono valide o sono vuote.');
                        }
                    }
                    fclose($handle);

                    // Reindirizza con uno stato di successo
                    wp_safe_redirect(admin_url('admin.php?page=importazione-mappe&import_status=success'));
                    exit;
                }
            }
        }

        // Reindirizza con uno stato di errore se qualcosa va storto
        wp_safe_redirect(admin_url('admin.php?page=importazione-mappe&import_status=error'));
        exit;
    }

    public function append_csv_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mappe_soluzioni';

        // Verifica il file CSV
        if (isset($_GET['file'])) {
            $file_name = sanitize_text_field($_GET['file']);
            $file_path = WP_CONTENT_DIR . '/uploads/import/' . $file_name;

            if (file_exists($file_path)) {
                if (($handle = fopen($file_path, 'r')) !== FALSE) {
                    // Leggi la prima riga per ottenere i nomi delle colonne
                    $headers = fgetcsv($handle, 1000, ';');
                    if ($headers) {
                        $headers = array_map(function ($header) {
                            return trim($header, '"'); // Rimuove virgolette doppie dai bordi
                        }, $headers);

                        // Rimuovi 'id_soluzione' dalle intestazioni se presente
                        $has_id_soluzione = false;
                        if (in_array('id_soluzione', $headers)) {
                            $headers = array_filter($headers, function ($header) {
                                return $header !== 'id_soluzione';
                            });
                            $has_id_soluzione = true;
                        }

                        // Assicurati che le intestazioni siano valide e presenti
                        if (count($headers) > 0) {
                            while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                                // Rimuovi virgolette doppie dai valori
                                $data = array_map(function ($value) {
                                    return trim($value, '"');
                                }, $data);

                                // Se 'id_soluzione' è stato rimosso dalle intestazioni, elimina il primo elemento dai dati
                                if ($has_id_soluzione) {
                                    array_shift($data); // Rimuove il primo elemento dai dati
                                }

                                // Verifica che la riga abbia lo stesso numero di elementi delle intestazioni
                                if (count($data) === count($headers)) {
                                    $row_data = array_combine($headers, $data);

                                    // Inserisci i dati nel database senza 'id_soluzione'
                                    $wpdb->insert(
                                        $table_name,
                                        [
                                            'slug_mappa' => sanitize_text_field($row_data['slug_mappa'] ?? ''),
                                            'slug_entita' => sanitize_text_field($row_data['slug_entita'] ?? ''),
                                            'punteggio' => intval($row_data['punteggio'] ?? 0),
                                            'domanda' => sanitize_text_field($row_data['domanda'] ?? ''),
                                            'domanda_alt_f' => sanitize_text_field($row_data['domanda_alt_f'] ?? ''),
                                            'risposta' => sanitize_text_field($row_data['risposta'] ?? ''),
                                            'risposta_alt_f' => sanitize_text_field($row_data['risposta_alt_f'] ?? ''),
                                            'lingua' => sanitize_text_field($row_data['lingua'] ?? ''),
                                        ]
                                    );
                                } else {
                                    error_log(count($data) . ' ' . count($headers) . ' Numero di elementi nella riga non corrisponde al numero di intestazioni. Riga: ' . implode(';', $data));
                                }
                            }
                        } else {
                            error_log('Le intestazioni del CSV non sono valide o sono vuote.');
                        }
                    }
                    fclose($handle);

                    // Reindirizza con uno stato di successo
                    wp_safe_redirect(admin_url('admin.php?page=importazione-mappe&import_status=append_success'));
                    exit;
                }
            }
        }

        // Reindirizza con uno stato di errore se qualcosa va storto
        wp_safe_redirect(admin_url('admin.php?page=importazione-mappe&import_status=append_error'));
        exit;
    }
}