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
        <!-- Titolo principale -->
        <h1>Calcolatore BMI</h1>

        <!-- Form sempre visibile in pagina -->
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

        <?php 
        // Viene eseguito solo se il form è stato inviato via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome']);
            $peso = trim($_POST['peso']);
            $altezza = trim($_POST['altezza']);

            if ($nome == "" || $peso == "" || $altezza == "") {
                echo "<br><div class='card'><h2>Campi non correttamente inseriti.</h2></div>";
            } else {
                // Pulizia e conversione numeri
                $peso_num = (float)str_replace(',', '.', $peso);
                $altezza_num = (float)str_replace(',', '.', $altezza);

                // Conversione cm -> m se necessario
                $altezza_m = ($altezza_num > 3) ? ($altezza_num / 100) : $altezza_num;
                
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
                    $fascia = "OBESITA";
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
        ?>
                <!-- Card del Risultato mostrata sotto il form nella stessa pagina -->
                <br>
                <div class="card <?= $classe ?>">
                    <p><strong>Nome:</strong> <?= htmlspecialchars($nome) ?></p>
                    <p><strong>Peso:</strong> <?= $peso_num ?> kg</p>
                    <p><strong>Altezza:</strong> <?= $altezza_m ?> m</p>
                    <div class="valore-bmi"><?= $bmi_formattato ?></div>
                    <div class="fascia"><?= $fascia ?></div>
                </div>
        <?php 
            }
        } 
        ?>
    </div>

</body>
</html>