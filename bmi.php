<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <title>Risultato BMI</title>
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