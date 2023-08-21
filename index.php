<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $capital = $_POST["capital"];
    $tasaInteres = $_POST["tasaInteres"] / 100; // Convertir a decimal
    $plazo = $_POST["plazo"];

    $cuotaMensual = $capital * ($tasaInteres / 12) / (1 - pow(1 + $tasaInteres / 12, -$plazo));
    $saldoRestante = $capital;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Amortización</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Calculadora de Amortización</h1>
        <form method="post">
            <label for="capital">Monto del Capital:</label>
            <input type="number" step="any" id="capital" name="capital" min="0" max="10000000000000000" required><br>

            <label for="tasaInteres">Tasa de Interés Anual (%):</label>
            <input type="number" step="any" id="tasaInteres" name="tasaInteres" min="0" max="60" required><br>

            <label for="plazo">Plazo en Meses:</label>
            
            <input type="number" step="1" id="plazo" name="plazo"  min="1" max="720" required><br>

            <input type="submit" value="Calcular">
        </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $totalPagado=0;
        $totalIntereses=0;
        $aniosTranscurridos = 0;
        echo '<h2>Tabla de Amortización</h2>';
        echo '<table border="1">
                <tr>
                    <th>Mes</th>
                    <th>Cuota Mensual</th>
                    <th>Intereses</th>
                    <th>Amortización</th>
                    <th>Saldo Restante</th>
                </tr>';

        for ($mes = 1; $mes <= $plazo; $mes++) {
            $intereses = $saldoRestante * ($tasaInteres / 12);
            $amortizacion = $cuotaMensual - $intereses;
            $saldoRestante -= $amortizacion;
            $totalPagado += $cuotaMensual;
            $totalIntereses += $intereses;

            
            echo '<tr>
                    <td>' . $mes . '</td>
                    <td>' . number_format($cuotaMensual,2, ',', '.') . ' €</td>
                    <td>' . number_format($intereses, 2, ',', '.') . ' €</td>
                    <td>' . number_format($amortizacion, 2, ',', '.') . ' €</td>
                    <td>' . number_format($saldoRestante, 2, ',', '.') . ' €</td>
                </tr>';

            if ($mes % 12 === 0) {
                $aniosTranscurridos++;
                echo '
                        <td colspan="5" style="background-color: #007BFF; text-align: center;">' . $aniosTranscurridos . ' años</td>
                    ';
            }    
        }
        echo '</table>';
        echo '<h2>Resumen</h2>';
        echo 'Capital Prestado: ' . number_format($capital , 2, ',', '.') . ' €<br>';
        echo 'Tipo de interés: ' . number_format($tasaInteres * 100, 2, ',', '.') . ' %<br>';
        echo 'Intereses Totales Pagados: ' . number_format($totalIntereses, 2, ',', '.') . ' €<br>';
        echo 'Costo Total del Préstamo: ' . number_format($totalPagado, 2, ',', '.') . ' €<br>';

    }

    ?>

</body>
</html>
