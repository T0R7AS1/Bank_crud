<?php
    
    function getSaskaita(){
        return json_decode(file_get_contents(__DIR__.'/saskaitos.json'), true);
    }

    function getSaskaitaById($id){
        $saskaitos = getSaskaita();
        foreach ($saskaitos as $val) {
            if ($val['id'] == $id) {
                return $val;
            }
        }
        return null;
    }
    
    function createSaskaita($data){
        $saskaitos = getSaskaita();
        if (empty($data['vardas'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Vardas yra privalomas</h5>
            </div>
            <?php
            return;
        }
        if (empty($data['pavarde'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Pavarde yra privaloma</h5>
            </div>
            <?php
            return;
        }
        if (empty($data['saskaita'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Saskaitos numeris yra privalomas</h5>
            </div>
            <?php
            return;
        }
        if (empty($data['asmens_kodas'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Asmens kodas yra privalomas</h5>
            </div>
            <?php
            return;
        }
        if (strlen($data['vardas']) < 3) {
            ?>
            <div class="alert alert-danger">
                <h5>Vardas turi buti ilgesnis nei 3 simboliai</h5>
            </div>
            <?php
            return;
        }
        if (strlen($data['pavarde']) < 3) {
            ?>
            <div class="alert alert-danger">
                <h5>Pavarde turi buti ilgesne nei 3 simboliai</h5>
            </div>
            <?php
            return;
        }
        if (strlen($data['asmens_kodas']) != 11) {
            ?>
            <div class="alert alert-danger">
                <h5>Asmens kodas turi buti 11 simboliu ilgio</h5>
            </div>
            <?php
            return;
        }
        $data['id'] = 1;
        foreach ($saskaitos as $key => $value) {
            if ($value['asmens_kodas'] == $data['asmens_kodas']) {
                ?>
                <div class="alert alert-danger">
                    <h5>Toks asmens kodas jau yra</h5>
                </div>
                <?php
                return;
            }
            while ($value['id'] == $data['id']) {
                $data['id']++;
            }
        }
        $data['likutis'] = 0;
        $saskaitos[] = $data;
        include 'layouts/success.php';
        file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitos));

    }

    function removeFromSaskaita($data, $id){
        $saskaitos = getSaskaita();
        foreach ($saskaitos as $key => $value) {
            if ($value['id'] == $id) {
                (double)$value['likutis'] -= number_format((double)$data['likuti'], 2, '.', '');
                if ($data['likuti'] > $value['likutis']) {
                    $value['likutis'] = 0;
                }
                if ($data['likuti']) {
                    # code...
                }
                $saskaitos[$key] = $value;
                if (!$data['likuti']) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>Iveskite suma kiek norite nuskaiciuoti arba eikite atgal</h5>
                    </div>
                    <?php
                    return;
                }
                include 'layouts/success.php';
                file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitos));
            }
        }
    }

    function addToSaskaita($data, $id){
        $saskaitos = getSaskaita();
        foreach ($saskaitos as $key => $value) {
            if ($value['id'] == $id) {
                if (!$data['likuti']) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>Iveskite suma kiek norite prideti arba eikite atgal</h5>
                    </div>
                    <?php
                    return;
                }
                (double)$value['likutis'] += number_format((double)$data['likuti'], 2, '.', '');
                $saskaitos[$key] = $value;
                include 'layouts/success.php';
                file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitos));
            }
        }
    }
    
    function deleteSaskaita($id){
        $saskaitos = getSaskaita();
        foreach ($saskaitos as $key => $value) {
            if ($value['id'] == $id) {
                if ($value['likutis'] == 0) {
                    array_splice($saskaitos, $key, 1);
                }else{
                    header('Location: index.php');
                    return;
                }
            }
        }
        header('Location: index.php');
        include 'layouts/success.php';
        file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitos));
    }
?>