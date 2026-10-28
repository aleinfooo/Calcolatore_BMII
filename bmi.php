<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultato BMI</title>
    <style>
        /* Stili Generali e Layout Centrato */
        body {
            background-color: #f1f3f5;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Struttura Base della Card */
        .card {
            width: 360px;
            padding: 24px;
            border-radius: 12px;
            border: 3px solid transparent;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
            text-align: center;
        }

        /* Stili del contenuto della Card */
        .card p {
            margin: 6px 0;
            font-size: 15px;
            color: #333333;
            text-align: left;
        }

        .valore-bmi {
            font-size: 48px;
            font-weight: bold;
            margin: 18px 0 6px 0;
            color: #1f2328;
        }

        .fascia {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* --- LE 4 CLASSI DINAMICHE PER I COLORI --- */

        /* 1. Sottopeso */
        .card.sottopeso {
            background-color: #E3EEF9;
            border-color: #2F6FB3;
        }
        .card.sottopeso .fascia {
            color: #2F6FB3;
        }

        /* 2. Normopeso */
        .card.normopeso {
            background-color: #E3F4E6;
            border-color: #256D34;
        }
        .card.normopeso .fascia {
            color: #256D34;
        }

        /* 3. Sovrappeso */
        .card.sovrappeso {
            background-color: #FCEBD7;
            border-color: #9A4F06;
        }
        .card.sovrappeso .fascia {
            color: #9A4F06;
        }

        /* 4. Obesità */
        .card.obesita {
            background-color: #FBE2E2;
            border-color: #B32D2D;
        }
        .card.obesita .fascia {
            color: #B32D2D;
        }

        /* Link di ritorno sotto la card */
        a.btn-ricalcola {
            margin-top: 16px;
            color: #1f2328;
            text-decoration: none;
            font-weight: bold;
        }

        a.btn-ricalcola:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] != "POST"){
            header("Location: form.html");
            exit();
        }

        $nome = trim($_POST['nome']);
        $peso = trim($_POST['peso']);
        $altezza = trim($_POST['altezza']);

        if ($nome == "" || $peso == "" || $altezza == "") {
            echo "<div class='card'><h2>Campi non correttamente inseriti.</h2></div>";
            echo "<br><a href='form.html' class='btn-ricalcola'>Calcola di nuovo</a>";
        } else {
            // Pulizia numeri da eventuali virgole
            $peso_num = (float)str_replace(',', '.', $peso);
            $altezza_num = (float)str_replace(',', '.', $altezza);

            // Conversione dell'altezza da cm a metri per la formula
            $altezza_m = ($altezza_num > 3) ? ($altezza_num / 100) : $altezza_num;
            
            $bmi = 0;
            if ($altezza_m > 0) {
                // Calcolo BMI: peso (kg) / altezza (m)^2
                $bmi = $peso_num / ($altezza_m * $altezza_m);
            }
            
            $bmi_formattato = number_format($bmi, 2, '.', '');

            // Determinazione della fascia e della classe CSS
            if ($bmi < 18.5) {
                $classe = "sottopeso";
                $fascia = "SOTTOPESO";
            } else if ($bmi >= 18.5 && $bmi <= 24.9) {
                $classe = "normopeso";
                $fascia = "NORMOPESO";
            } else if ($bmi >= 25 && $bmi <= 29.9) {
                $classe = "sovrappeso";
                $fascia = "SOVRAPPESO";
            } else {
                $classe = "obesita";
                $fascia = "OBESITÀ";
            }

            // Output della Card Risultato
            echo "<h1>Risultato per $nome</h1>";
            echo "<div class='card $classe'>";
            echo "  <p><strong>Nome:</strong> $nome</p>";
            echo "  <p><strong>Peso:</strong> $peso_num kg</p>";
            echo "  <p><strong>Altezza:</strong> $altezza_m m</p>";
            echo "  <div class='valore-bmi'>$bmi_formattato</div>";
            echo "  <div class='fascia'>$fascia</div>";
            echo "</div>";
            echo "<br><a href='form.html' class='btn-ricalcola'>Calcola di nuovo</a>";

            $data_ora_date = date("d/m/Y");
            $data_ora_time = date("H:i:s");
            $ip_address = $_SERVER['REMOTE_ADDR'];

            // Creazione e scrittura dei valori sul file log.csv
            $nf = "log.csv";
            $file = fopen($nf, "a");
            if ($file) {
                $record = date("d/m/Y") . ", ";
                $record .= date("H:i:s") . ", ";
                $record .= $_SERVER['REMOTE_ADDR'] . ", ";
                $record .= $nome . ", ";
                $record .= $peso_num . ", ";
                $record .= $altezza_m . ", ";
                $record .= $bmi_formattato . ", ";
                $record .= $classe . ";\r\n";
                
                fwrite($file, $record);
                fclose($file);
            }
        }
    ?>
</body>
</html>