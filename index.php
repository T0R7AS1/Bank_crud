<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'layouts/header.php';
require 'saskaitos.php';

$saskaitos = json_decode(file_get_contents(__DIR__.'/saskaitos.json'), true);
usort($saskaitos, function ($a, $b) {
    return $a['pavarde'] <=> $b['pavarde'];
});

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (strpos($url, "create=success") == true) {
    ?>
    <div class="alert alert-success">
    <h5>Vartotojas buvo sukurtas sekmingai</h5>
    </div>
    <?php
}
if (strpos($url, "delete=error") == true) {
    ?>
    <div class="alert alert-danger">
    <h5>Negalima istrinti vartotojo nes jo saskaitoje yra lesu</h5>
    </div>
    <?php
}
if (strpos($url, "delete=success") == true) {
    ?>
    <div class="alert alert-success">
    <h5>Vartotojas buvo istrintas sekmingai</h5>
    </div>
    <?php
}
if (strpos($url, "add=success") == true) {
    ?>
    <div class="alert alert-success">
    <h5>Vartotojui lesos buvo pridetos sekmingai</h5>
    </div>
    <?php
}
if (strpos($url, "rem=success") == true) {
    ?>
    <div class="alert alert-success">
    <h5>Vartotojui lesos buvo nuskaiciuotos sekmingai</h5>
    </div>
    <?php
}
if (strpos($url, "rem=all") == true) {
    ?>
    <div class="alert alert-success">
    <h5>Vartotojui lesos buvo nuskaiciuotos sekmingai dabar jo saskaita yra lygi nuliui ir ja galima istrinti</h5>
    </div>
    <?php
}
?>
<table class="table">
    <thead>
        <th>Vardas</th>
        <th>Pavarde</th>
        <th>Saskaita</th>
        <th>Asmens kodas</th>
        <th>Likutis</th>
        <th style="text-align:right; width: 30%" >Actions</th>
    </thead>
    <tbody>
        <?php foreach ($saskaitos as $val): ?>
            <tr>
                <td><?php echo $val['vardas']?></td>
                <td><?php echo $val['pavarde']?></td>
                <td><?php echo $val['saskaita']?></td>
                <td><?php echo $val['asmens_kodas']?></td>
                <td><?php echo $val['likutis']?>Eur</td>
                <td style="text-align:right;">
                <a href="prideti.php?id=<?php echo $val['id']?>" class="btn btn-success">Prideti Lesu</a>
                <a href="nuimti.php?id=<?php echo $val['id']?>" class="btn btn-warning">Nuskaiciuoti Lesu</a>
                <form action="delete.php" method="POST" class="d-inline-block">
                    <input type="hidden" name="id" value="<?php echo $val['id']?>" >
                    <button class="btn btn-danger">Istrinti</button>
                </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'layouts/footer.php';?>