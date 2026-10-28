<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
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
        a {
            margin-top: 16px;
            color: #1f2328;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <?php
    if (isset($_POST['peso']) && isset($_POST['altezza'])) {
        
        $nome = htmlspecialchars($_POST['nome']);
        
        // Sostituiamo eventuale virgola con il punto per evitare che diventi 0
        $peso_str = str_replace(',', '.', $_POST['peso']);
        $altezza_str = str_replace(',', '.', $_POST['altezza']);

        $peso = (float)$peso_str;
        $altezza = (float)$altezza_str;

        // Se l'altezza viene inserita in cm (es. 175 invece di 1.75), la convertiamo in metri
        if ($altezza > 3) {
            $altezza = $altezza / 100;
        }

        // Verifica dati validi
        if ($altezza > 0 && $peso > 0) {
            
            // Calcolo BMI[cite: 1, 2]
            $bmi = $peso / ($altezza * $altezza);
            $bmi_arrotondato = number_format($bmi, 2, '.', ''); // Formato con 2 decimali[cite: 2]

            // Assegnazione della fascia e della classe CSS[cite: 2]
            if ($bmi < 18.5) {
                $classe = "sottopeso";
                $fascia = "SOTTOPESO";
            } elseif ($bmi >= 18.5 && $bmi < 25) {
                $classe = "normopeso";
                $fascia = "NORMOPESO";
            } elseif ($bmi >= 25 && $bmi < 30) {
                $classe = "sovrappeso";
                $fascia = "SOVRAPPESO";
            } else {
                $classe = "obesita";
                $fascia = "OBESITA";
            }

            // Stampa della card[cite: 2]
            echo "<div class='card " . $classe . "'>";
            echo "<p><strong>Nome:</strong> " . $nome . "</p>";
            echo "<p><strong>Peso:</strong> " . $peso . " kg</p>";
            echo "<p><strong>Altezza:</strong> " . $altezza . " m</p>";
            echo "<div class='valore-bmi'>" . $bmi_arrotondato . "</div>";
            echo "<div class='fascia'>" . $fascia . "</div>";
            echo "</div>";

        } else {
            echo "<div class='card'><h2>Inserisci valori di peso e altezza validi.</h2></div>";
        }

    } else {
        echo "<div class='card'><h2>Dati mancanti.</h2></div>";
    }
    ?>

    <a href="form.html">Calcola di nuovo</a>

</body>
</html>