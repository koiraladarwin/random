<?php
// Simple Local SQL Executor (ONLY FOR LOCALHOST / DEV)
$mysqli = new mysqli("192.168.101.81", "financeUser", "UVE1bcPui2bh", "apex_finance");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['sql'])) {
    $sql = $_POST['sql'];

    $result = $mysqli->query($sql);

    if ($result === false) {
        $output = "Query failed: " . $mysqli->error;
    } elseif ($result instanceof mysqli_result) {
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $output = "<pre>" . print_r($rows, true) . "</pre>";
    } else {
        $output = "Query executed successfully. Affected rows: " . $mysqli->affected_rows;
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Local SQL Executor</title>
</head>
<body>
    <h2>Local SQL Executor</h2>
    <form method="post">
        <textarea name="sql" rows="8" cols="80" placeholder="Type any SQL command here"></textarea><br><br>
        <input type="submit" value="Run SQL">
    </form>
    <hr>
    <?php if ($output) echo $output; ?>
</body>
</html>
