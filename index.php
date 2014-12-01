<html>
<head>
    <script src="jquery.js"></script>
</head>
<body align='center'>

<h1> Advences </h1>
<hr>

<div>
    <h1> Systeme de repartition des personnes sur les logements d'hotel </h1>
    <br>

    <form name="form" method="post">
        <fieldset>
            <legend>Formulaire:</legend>
            <strong>Personnes:</strong> <input type="text" size="30" name="personnes" id="personnes"><br><br>
            <strong>Logements:</strong> <br>

            <table align='center'>
                <tr>
                    <td> Single: <input type="checkbox" name="Single"></td>
                    <td> Double: <input type="checkbox" name="Double"></td>
                </tr>

                <tr>
                    <td> Triple: <input type="checkbox" name="Triple"></td>
                    <td> Quadruple: <input type="checkbox" name="Quadruple"></td>
                </tr>
            </table>

        </fieldset>
        <br>
        <input type="submit" value="Calculer">
    </form>

</div>

<script>
    $(document).ready(function () {
        $('form').submit(function () {
            var pers = $('#personnes').val();
            if (pers == '') {
                alert('Entrez le nombre des personnes!');
                return false;
            }
            else if (!$.isNumeric(pers)) {
                alert('Entrez un nombre de personne valide!');
                return false;
            }
            else if (pers <= 0) {
                alert('Entrez un nombre de personne superieur a zero');
                return false;
            }

            var bool = false;
            $('form input[type="checkbox"]').each(function () {
                bool = bool || $(this).prop('checked');
            });

            if (!bool) {
                alert('Selectionnez au moins un logement!');
                return false;
            }

            return true;

        });
    });

</script>

<?php
/*
 * (c) Ala Eddine Khefifi <alakhefifi@gmail.com>
 *
 */

require_once "Hotel.php";

if (isset($_POST['personnes'])) {
    $personnes = $_POST['personnes'];
    $logement = array();
    $log = '';

    if (isset($_POST['Single'])) {
        $logement['Single'] = 1;
    }
    if (isset($_POST['Double'])) {
        $logement['Double'] = 2;
    }
    if (isset($_POST['Triple'])) {
        $logement['Triple'] = 3;
    }
    if (isset($_POST['Quadruple'])) {
        $logement['Quadruple'] = 4;
    }

    foreach ($logement as $key => $value) {
        $log .= $key . ' / ';
    }

    echo "
	<table align='center'>
	<tr> <td> <strong>Personnes:</strong> $personnes </td> </tr>
	<tr> <td>  </td> 	</tr>
	<tr> <td> <strong>Logements: </strong> $log </td> </tr>
	<tr> <td>  </td> 	</tr>
	</table>
	";

    echo '<span style="color:red"><h3>Resultat:</h3></span>';


    $obj = new Hotel($personnes, $logement);
    $obj->execute();
    $resultat = $obj->getResult();

    $i = 1;
    echo "<table align='center'>";
    foreach ($resultat as $key => $value) {
        echo "<tr> <td> <strong>Proposition $i </strong>:  $value </td> </tr>";
        $i++;
    }
    echo "</table>";
    echo "<br>";

}
?>
<br>
<hr>
<strong>(c) Developed by, Ala Eddine Khefifi</strong>
</body>

</html>
