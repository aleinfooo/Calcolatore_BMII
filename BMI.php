<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolatore BMI</title>
</head>
<body>
    <?php
    // Controlla se i dati esistono e se l'altezza è maggiore di 0 per evitare la divisione per zero
    if (isset($_POST['nome']) && isset($_POST['peso']) && isset($_POST['altezza']) && $_POST['altezza'] > 0) {
    
        $nome = $_POST['nome'];
        $peso = $_POST['peso'];
        $altezza = $_POST['altezza'];

        // CORREZIONE 1: Aggiunto l'asterisco per la moltiplicazione e arrotondato a 2 decimali
        $bmi = $peso / ($altezza * $altezza);
        $bmi_arrotondato = round($bmi, 2);

        if ($bmi < 18.5) {
            $classe_css = "sottopeso"; $nome_fascia = "Sottopeso";
        } elseif ($bmi < 25) {
            $classe_css = "normopeso"; $nome_fascia = "Normopeso";
        } elseif ($bmi < 30) {
            $classe_css = "sovrappeso"; $nome_fascia = "Sovrappeso";
        } else {
            $classe_css = "obeso"; $nome_fascia = "Obeso";
        }
    ?>

    <div class="card <?php echo $classe_css; ?>">
        <p><strong>Nome:</strong> <?php echo $nome; ?></p>
        <p><strong>Peso:</strong> <?php echo $peso; ?> kg</p>
        <p><strong>Altezza:</strong> <?php echo $altezza; ?> m</p>
        
        <!-- CORREZIONE 2: Aggiunto il valore numerico del BMI -->
        <div class="bmi-value"><?php echo $bmi_arrotondato; ?></div>
        <div class="fascia"><?php echo $nome_fascia; ?></div>
    </div>

    <?php
    } else {
        // Se apri bmi.php direttamente, ti avvisa invece di darti errori strani
        echo "<div class='card'><p>Dati mancanti. Torna indietro e compila il form.</p></div>";
    }
    ?>

    <!-- Link per tornare indietro -->
    <a href="form.html">Calcola di nuovo</a>
</body>
</html>