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
        if (!preg_match("#[a-zA-Z]+#", $data['vardas'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Vardas gali susidaryti tik is raidziu :)</h5>
            </div>
            <?php
            return;
        }
        if (!preg_match("#[a-zA-Z]+#", $data['pavarde'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Pavarde gali susidaryti tik is raidziu :)</h5>
            </div>
            <?php
            return;
        }
        if (!is_numeric($data['saskaita'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Saskaitos numeryje gali buti tik skaiciai :)</h5>
            </div>
            <?php
            return;
        }
        if (!is_numeric($data['asmens_kodas'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Asmens kode gali buti tik skaiciai :)</h5>
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
        file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitos));
        header('Location: index.php?create=success');
    }

    function removeFromSaskaita($data, $id){
        $saskaitos = getSaskaita();
        foreach ($saskaitos as $key => $value) {
            if ($value['id'] == $id) {
                (double)$value['likutis'] -= number_format((double)$data['likuti'], 2, '.', '');
                if ($data['likuti'] > $value['likutis']) {
                    $value['likutis'] = 0;
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
                if ($data['likuti'] < 0) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>Is saskaitos negalima nuskaiciuoti minusines sumos </h5>
                    </div>
                    <?php
                    return;
                }
                if (!is_numeric($data['likuti'])) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>Is saskaitos negalima nuimti raidziu arba simboliu nes ju nera :) (jeigu raset su kableliu prasome naudoti taskeli)</h5>
                    </div>
                    <?php
                    return;
                }else{
                    if ($value['likutis'] == 0) {
                        header("Location: index.php?rem=all");
                    }else{
                        header("Location: index.php?rem=success");
                    }
                    file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitos));
                }
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
                if ($data['likuti'] < 0) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>I saskaita negalima prideti minusines sumos </h5>
                    </div>
                    <?php
                    return;
                }
                if (!is_numeric($data['likuti'])) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>I saskaita negalima prideti raidziu arba simboliu :) (jeigu raset su kableliu prasome naudoti taskeli)</h5>
                    </div>
                    <?php
                    return;
                }else{
                    (double)$value['likutis'] += number_format((double)$data['likuti'], 2, '.', '');
                    $saskaitos[$key] = $value;
                    file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitos));
                    header("Location: index.php?add=success");
                }
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
                    header('Location: index.php?delete=error');
                    return;
                }
            }
        }
        header('Location: index.php?delete=success');
        file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitos));
    }
?>