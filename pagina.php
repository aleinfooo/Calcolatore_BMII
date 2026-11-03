<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calcolatore BMI</title>
</head>
<body>

    <div class="main-container">
        <h1>Calcolatore BMI</h1>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <?php
                $nome = trim($_POST['nome']);
                $peso = trim($_POST['peso']);
                $altezza = trim($_POST['altezza']);

                if ($nome == "" || $peso == "" || $altezza == "") {
                    echo "<div class='card'><h2>Campi non correttamente inseriti.</h2></div>";
                    echo "<br><a href='pagina.php' class='btn-ricalcola'>Calcola di nuovo</a>";
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

                    // Scrittura dei valori sul file log.csv
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
            ?>
                    <!-- Output della Card Risultato -->
                    <div class="card <?= $classe ?>">
                        <p><strong>Nome:</strong> <?= htmlspecialchars($nome) ?></p>
                        <p><strong>Peso:</strong> <?= $peso_num ?> kg</p>
                        <p><strong>Altezza:</strong> <?= $altezza_m ?> m</p>
                        <div class="valore-bmi"><?= $bmi_formattato ?></div>
                        <div class="fascia"><?= $fascia ?></div>
                    </div>
                    <br>
                    <a href="pagina.php" class="btn-ricalcola">Calcola di nuovo</a>
            <?php } ?>

        <?php else: ?>
            <!-- Form mostrato all'apertura della pagina (GET) -->
            <div class="card">
                <form action="pagina.php" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Es. Mario" required>
                    </div>

                    <div class="form-group">
                        <label for="peso">Peso (kg)</label>
                        <input type="number" id="peso" name="peso" step="0.1" placeholder="Es. 70" required>
                    </div>

                    <div class="form-group">
                        <label for="altezza">Altezza (cm)</label>
                        <input type="number" id="altezza" name="altezza" placeholder="Es. 175" required>
                    </div>

                    <button type="submit">Calcola</button>
                </form>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>