<?php
    /**
     * @var RenamingFiles $obgRenamingFiles
     */
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RENAME MUSIC</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="shadow-lg card col">
                <div class="card-body">
                    <h5 class="card-title">Количество файлов: <?=$obgRenamingFiles->get_count_in_source()?></h5>
                    <div class="music_source">
                        <?php foreach ($obgRenamingFiles->get_array_in_source() as $data):?>
                            <p class="m-0"><?=$data?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="shadow-lg offset-1 card col">
                <div class="card-body">
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped bg-dark" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="music_ready">
                    </div>
                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-dark btn-block ">START</button>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-border d-none" role="status">
                            <span class="sr-only ">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-5">
            <div class="card col">
                <div class="card-body">
                    <input name="path_to_source" class="form-control" type="text" value="<?=$obgRenamingFiles->get_path_to_source()?>" disabled>
                </div>
            </div>
            <div class="card col offset-1">
                <div class="card-body">
                    <input name="path_to_ready" class="form-control" type="text" value="<?=$obgRenamingFiles->get_path_to_ready()?>" disabled>
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
