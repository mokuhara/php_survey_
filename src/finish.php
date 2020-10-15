<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script type="module" src="./main.js"></script>
    <?php
    try {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $favorite = $_POST["favorite"];

        require('./db/Repository.php');
        $sql = "select favorite, count(*) as cnt from survey group by favorite";
        //mysql利用する場合変更
        $type = "mysql";
        //file利用する場合変更
        // $type = "file";

        $db = new Repository($type);
        $db->save($name, $email, $favorite);
        $json = $db->read($sql);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.20/lodash.min.js"></script>
    <div class="data" data-name="<?php echo htmlspecialchars($json, ENT_QUOTES, 'UTF-8'); ?>"></div>

    <div id="app">
        <div>
            <Piec />
            <Barc />
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <!-- <script type="text/javascript" src="./chart/bar.js"></script> -->
    <script type="module" src="./main.js"></script>

    <a href="../index.php">戻る</a>
</body>

</html>