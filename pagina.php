<?php 
// Viene eseguito solo se il form è stato inviato via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $peso = trim($_POST['peso']);
    $altezza = trim($_POST['altezza']);

    // Controllo campi vuoti o nome numerico
    if ($nome == "" || is_numeric($nome) || $peso == "" || $altezza == "") {
        echo "<br><div class='card'><h2>Campi non correttamente inseriti.</h2></div>";
    } else {
        // Pulizia numeri da eventuali virgole
        $peso_num = (float)str_replace(',', '.', $peso);
        $altezza_num = (float)str_replace(',', '.', $altezza);

        // Conversione cm -> m usando il classico IF
        if ($altezza_num > 3) {
            $altezza_m = $altezza_num / 100;
        } else {
            $altezza_m = $altezza_num;
        }
        
        $bmi = 0;
        if ($altezza_m > 0) {
            $bmi = $peso_num / ($altezza_m * $altezza_m);
        }
        
        $bmi_formattato = number_format($bmi, 2, '.', '');

        // Determinazione classe CSS e fascia
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

        // Scrittura sul file log.csv
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

        // Stampa a schermo con gli ECHO classici
        echo "<br>";
        echo "<div class='card $classe'>";
        echo "  <p><strong>Nome:</strong> " . htmlspecialchars($nome) . "</p>";
        echo "  <p><strong>Peso:</strong> $peso_num kg</p>";
        echo "  <p><strong>Altezza:</strong> $altezza_m m</p>";
        echo "  <div class='valore-bmi'>$bmi_formattato</div>";
        echo "  <div class='fascia'>$fascia</div>";
        echo "</div>";
    }
} 
?>
