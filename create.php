<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
include 'layouts/header.php';
require  __DIR__.'/saskaitos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createSaskaita($_POST);
}



?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <a href="index.php" class="btn btn-primary btn-block m-0 ">Atgal</a>
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Naujos saskaitos atidarymas</h3></div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label class="mb-1" for="inputProjectname">Vardas</label>
                            <input type="text" class="form-control" placeholder="Irasykite varda" name="vardas" autocomplete="off" pattern="[a-zA-Z]{1,}">
                        </div>
                        <div class="form-group">
                            <label class=" mb-1" for="inputProjectname">Pavarde</label>
                            <input class="form-control" placeholder="Irasykite pavarde" name="pavarde" autocomplete="off" pattern="[a-zA-Z]{1,}">
                        </div>
                        <div class="form-group">
                            <label class=" mb-1" for="inputProjectname">Saskaitos Numeris</label>
                            <input class="form-control" placeholder="Irasykite saskaitos numeri" name="saskaita" autocomplete="off" pattern="[1-9]{1,}">
                        </div>
                        <div class="form-group">
                            <label class=" mb-1" for="inputProjectname">Asmens Kodas</label>
                            <input class="form-control" placeholder="Irasykite asmens_koda" name="asmens_kodas" autocomplete="off" pattern="[1-9]{1,}">
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-4">Prideti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>  
</div>