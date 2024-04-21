
CREATE TABLE IF NOT EXISTS Accounts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    account_number TEXT NOT NULL
);


CREATE TABLE IF NOT EXISTS Items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    item_number TEXT NOT NULL,
    description TEXT NOT NULL,
    unit_cost REAL NOT NULL
);


CREATE TABLE IF NOT EXISTS PurchaseOrders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    account_id INTEGER NOT NULL,
    FOREIGN KEY (account_id) REFERENCES Accounts(id)
);


CREATE TABLE IF NOT EXISTS PurchaseOrderItems (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    po_id INTEGER NOT NULL,
    item_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    total_cost REAL NOT NULL,
    FOREIGN KEY (po_id) REFERENCES PurchaseOrders(id),
    FOREIGN KEY (item_id) REFERENCES Items(id)
);
