<?php
$db = new SQLite3('database.sqlite');
$results = $db->query("SELECT account_number FROM Accounts");
$accounts = [];

while ($row = $results->fetchArray()) {
    $accounts[] = $row['account_number'];
}

header('Content-Type: application/json');
echo json_encode($accounts);
?>
