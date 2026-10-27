<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Risultato BMI</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php
    // Legge nome, peso, altezza dalla pagina precedente
    if (isset($_POST['peso']) && isset($_POST['altezza'])) {
        
        $nome = htmlspecialchars($_POST['nome']);
        $peso = (float)$_POST['peso'];
        $altezza = (float)$_POST['altezza'];

        if ($altezza <= 0) {
            echo "<div class='card'><h2>L'altezza deve essere maggiore di zero.</h2><a href='form.html'>Calcola di nuovo</a></div>";
            exit;
        }

        // Calcolo: BMI = peso / (altezza in m)²[cite: 2]
        $bmi = $peso / ($altezza * $altezza);
        
        // BMI con 2 decimali[cite: 2]
        $bmi_arrotondato = number_format($bmi, 2, ',', '.');

        // Assegnazione classi per la fascia
        if ($bmi < 18.5) {
            $classe = "sottopeso"; $fascia = "SOTTOPESO";
        } elseif ($bmi < 25) {
            $classe = "normopeso"; $fascia = "NORMOPESO";
        } elseif ($bmi < 30) {
            $classe = "sovrappeso"; $fascia = "SOVRAPPESO";
        } else {
            $classe = "obeso"; $fascia = "OBESO";
        }

        // Mostra UNA card con due classi: "card" + la classe della fascia[cite: 2]
        echo "<div class='card $classe'>";
        
        // Mostra nome e dati inseriti[cite: 2]
        echo "<p>Nome: $nome</p>";
        echo "<p>Peso: $peso kg</p>";
        echo "<p>Altezza: $altezza m</p>";
        
        // Mostra BMI (grande, 48px impostato nel CSS)[cite: 2]
        echo "<div class='valore-bmi'>$bmi_arrotondato</div>";
        
        // Mostra fascia in maiuscolo[cite: 2]
        echo "<h2>$fascia</h2>";
        
        echo "</div>";

    } else {
        echo "<div class='card'><h2>Dati mancanti.</h2></div>";
    }
    ?>

    <br>
    <!-- Sotto la card, link "Calcola di nuovo" verso form.html[cite: 2] -->
    <a href="form.html">Calcola di nuovo</a>

</body>
</html>