<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Risultato BMI</title>
      <style>
        /* Impostazioni di base e reset */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            /* Spazio laterale di 60px come richiesto */
            padding: 0 60px;
            /* Altezza minima per permettere il centraggio verticale */
            min-height: 100vh;
            /* Utilizzo Flexbox per centrare orizzontalmente e verticalmente */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* Colori e font specificati */
            background-color: #f1f3f5;
            color: #1f2328;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* Stile del contenitore principale per allineare titolo e card */
        .main-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Stile del titolo */
        h1 {
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 24px;
            text-align: center;
        }

        /* Stile della Card bianca */
        .card {
            background-color: #ffffff;
            width: 100%;
            /* Larghezza fissa massima a 360px, ma reattiva su schermi molto piccoli */
            max-width: 360px; 
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .card-sottopeso {
            background-color: #ffffff;
            width: 100%;
            /* Larghezza fissa massima a 360px, ma reattiva su schermi molto piccoli */
            max-width: 360px; 
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-normopeso {
            background-color: #ffffff;
            width: 100%;
            /* Larghezza fissa massima a 360px, ma reattiva su schermi molto piccoli */
            max-width: 360px; 
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-sovrappeso {
            background-color: #ffffff;
            width: 100%;
            /* Larghezza fissa massima a 360px, ma reattiva su schermi molto piccoli */
            max-width: 360px; 
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-obeso {
            background-color: #ffffff;
            width: 100%;
            /* Larghezza fissa massima a 360px, ma reattiva su schermi molto piccoli */
            max-width: 360px; 
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Stili per i gruppi del form (spaziatura tra i campi) */
        .form-group {
            margin-bottom: 16px;
        }

        /* Le label occupano una riga intera */
        label {
            display: block;
            width: 100%;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 14px;
        }

        /* Gli input occupano una riga intera */
        input {
            display: block;
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-family: inherit;
            font-size: 16px;
            color: #1f2328;
            background-color: #f9fafb;
            transition: border-color 0.2s ease;
        }

        input:focus {
            outline: none;
            border-color: #1f2328;
        }

        /* Stile del pulsante di Submit */
        button[type="submit"] {
            display: block;
            width: 100%;
            background-color: #1f2328;
            color: #f1f3f5;
            padding: 12px;
            margin-top: 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button[type="submit"]:hover {
            background-color: #2c323a;
        }
    </style>
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

        // Calcolo: BMI 
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