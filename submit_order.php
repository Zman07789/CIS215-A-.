<?php
// Initialize SQLite database
$db = new SQLite3('database.sqlite');

// Check if connection was successful
if (!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}

// Get form data
$itemNumber = $_POST['item_number'];
$description = $_POST['description'];
$unitCost = $_POST['unit_cost'];
$quantity = $_POST['quantity'];
$accountNumber = $_POST['account_number'];

// Insert item into Items table
$stmt = $db->prepare("INSERT INTO Items (item_number, description, unit_cost) VALUES (:itemNumber, :description, :unitCost)");
$stmt->bindValue(':itemNumber', $itemNumber, SQLITE3_TEXT);
$stmt->bindValue(':description', $description, SQLITE3_TEXT);
$stmt->bindValue(':unitCost', $unitCost, SQLITE3_FLOAT);
$result = $stmt->execute();

if (!$result) {
    die("Error inserting item: " . $db->lastErrorMsg());
}

$itemId = $db->lastInsertRowID();

// Check if account exists
$stmt = $db->prepare("SELECT account_id FROM Accounts WHERE account_number = :accountNumber");
$stmt->bindValue(':accountNumber', $accountNumber, SQLITE3_TEXT);
$result = $stmt->execute();

$row = $result->fetchArray();

if (!$row) {
    // Insert account into Accounts table
    $stmt = $db->prepare("INSERT INTO Accounts (account_number) VALUES (:accountNumber)");
    $stmt->bindValue(':accountNumber', $accountNumber, SQLITE3_TEXT);
    $result = $stmt->execute();

    if (!$result) {
        die("Error inserting account: " . $db->lastErrorMsg());
    }

    $accountId = $db->lastInsertRowID();
} else {
    $accountId = $row['account_id'];
}

// Insert purchase order into PurchaseOrders table
$stmt = $db->prepare("INSERT INTO PurchaseOrders (account_id) VALUES (:accountId)");
$stmt->bindValue(':accountId', $accountId, SQLITE3_INTEGER);
$result = $stmt->execute();

if (!$result) {
    die("Error inserting purchase order: " . $db->lastErrorMsg());
}

$poId = $db->lastInsertRowID();

// Calculate total cost
$totalCost = $unitCost * $quantity;

// Insert item into PurchaseOrderItems table
$stmt = $db->prepare("INSERT INTO PurchaseOrderItems (po_id, item_id, quantity, total_cost) VALUES (:poId, :itemId, :quantity, :totalCost)");
$stmt->bindValue(':poId', $poId, SQLITE3_INTEGER);
$stmt->bindValue(':itemId', $itemId, SQLITE3_INTEGER);
$stmt->bindValue(':quantity', $quantity, SQLITE3_INTEGER);
$stmt->bindValue(':totalCost', $totalCost, SQLITE3_FLOAT);
$result = $stmt->execute();

if (!$result) {
    die("Error inserting purchase order item: " . $db->lastErrorMsg());
}

// Redirect to the form page
header('Location: index.html');
?>
