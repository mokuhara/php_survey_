<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <p id="keys"></p>
    <p id="values"></p>
    <canvas id="chart" width="400" height="400"></canvas>
</head>

<body>
    <a href="../index.php">戻る</a>

    <?php
    try {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $favorite = $_POST["favorite"];

        try {
            $dbh = new PDO(
                'mysql:dbname=test;host=localhost;charset=utf8',
                'root',
                'root',
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                )
            );
            $stmt = $dbh->prepare('insert into survey (name, email, favorite) values (:name, :email, :favorite)');
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':favorite', $favorite, PDO::PARAM_STR);
            $stmt->execute();

            $stmta = $dbh->query("select * from survey");
            $json = json_encode($stmta->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.20/lodash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script type="text/javascript" src="https://github.com/nagix/chartjs-plugin-colorschemes/releases/download/v0.2.0/chartjs-plugin-colorschemes.min.js"></script>
    <script>
        const json = JSON.parse('<?php echo $json; ?>');
        var groupCount = (group) => {
            return {
                count: group.length,
            }
        }
        const result = _(json)
            .groupBy('favorite')
            .mapValues(groupCount)
            .value();

        const labels = Object.keys(result)
        const data = Object.values(result).map(obj => {
            return obj.count
        })

        const ctx = document.querySelector('#chart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "好きな言語",
                    data: data,
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    colorschemes: {
                        scheme: 'brewer.Paired12'
                    }
                }
            }
        });
    </script>

</body>

</html>