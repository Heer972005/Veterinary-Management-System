DROP DATABASE vetmanagement;

CREATE DATABASE vetmanagement;
USE vetmanagement;
-- lab 3
insert INTO roles(roleName) VALUES
('Admin'),
('Doctor'),
('User'),
('Beautician'),
('Lab Technician');

INSERT INTO users(userName, email, password) VALUES
('Heer Mehta', 'heerm@gmail.com', '123456'),
('Dr. Carol', 'doctortest@gmail.com', '654321'),
('Riya Shah', 'riyam@gmail.com', '234567'),
('Amit Groomer', 'groomtest@gmail.com', '345678'),
('Lab Tech Raj', 'labtest@gmail.com', '456789');

INSERT INTO user_phones(userID, phone) VALUES
(1, '9876543210'),
(1, '9998887776'),  -- Heer has 2 numbers (multivalued handled)
(2, '9123456780'),
(3, '9012345678'),
(4, '9988776655'),
(5, '9876501234');

-- WHY:
-- Phone is multivalued → separate table (normalization)

-- 4. USER ROLES
INSERT INTO user_roles(userID, roleID) VALUES
(1, 3), -- Heer → User
(1, 1), -- Heer → Admin (multi-role example)
(2, 2), -- Doctor
(3, 3), -- User
(4, 4), -- Beautician
(5, 5); -- Lab Technician

-- WHY:
-- Many-to-many (Users ↔ Roles) resolved using user_roles table

INSERT INTO categories(catName) VALUES
('Food'),
('Toys'),
('Medicine'),
('Grooming');

INSERT INTO products(proName, catID, price, description) VALUES
('Dog Food', 1, 500, 'Healthy dog food'),
('Cat Toy', 2, 200, 'Fun toy'),
('Pet Shampoo', 4, 300, 'Cleaning shampoo'),
('Antibiotic Syrup', 3, 150, 'Medicine for pets');
INSERT INTO products(proName, catID, price, description) VALUE
('Comb', 4, 500, 'comb for pet');
select * from products;
delete from products where productID=6;
INSERT INTO pets(userID, petName, species, breed, age, gender) VALUES
(1, 'Bruno', 'Dog', 'Labrador', 3, 'Male'),
(3, 'Kitty', 'Cat', 'Persian', 2, 'Female');

INSERT INTO doctors(userID, specialization) VALUES
(2, 'General Physician');

INSERT INTO appointments(petID, doctorID, appointmentDate, appointmentStatus) VALUES
(1, 1, '2026-04-30 10:00:00', 'Scheduled'),
(2, 1, '2026-04-30 11:00:00', 'Completed');

INSERT INTO prescriptions(appointmentID, notes) VALUES
(2, 'Fever and mild infection');

INSERT INTO prescriptionItems(prescriptionID, productID, quantity) VALUES
(1, 4, 2),
(1, 1, 1);

INSERT INTO cart(userID) VALUES
(1),
(3);

INSERT INTO cart_items(cartID, productID, quantity) VALUES
(1, 1, 2),
(1, 2, 1),
(2, 3, 1);

INSERT INTO addresses(userID, addressLine, state, country, city, pincode) VALUES
(1, 'Street 1', 'Gujarat', 'India', 'Rajkot', '360001'),
(3, 'Street 2', 'Gujarat', 'India', 'Ahmedabad', '380001');


INSERT INTO orders(userID, orderDate, totalAmt, orderStatus, addressID) VALUES
(1, '2026-04-30', 700, 'Ordered', 1);

INSERT INTO orderItems(orderID, productID, quantity, price) VALUES
(1, 1, 1, 500),
(1, 2, 1, 200);

INSERT INTO payments(orderID, amt, method, payStatus) VALUES
(1, 700, 'UPI', 'Completed');


INSERT INTO deliveries(orderID, deliveryStatus, deliveryDate) VALUES
(1, 'Out for Delivery', '2026-05-01');

INSERT INTO services(serviceName, price, durationMins) VALUES
('Grooming', 500, 60),
('Bathing', 300, 30);

INSERT INTO beauticians(userID) VALUES
(4);

INSERT INTO serviceBookings(userID, petID, serviceID, bookingDate, bookingTime, serviceStatus) VALUES
(1, 1, 1, '2026-05-02', '10:00:00', 'Pending');

INSERT INTO serviceAssign(bookingID, beauticianID) VALUES
(1, 1);

INSERT INTO inventory(productID, quantity, expiryDate) VALUES
(1, 50, '2027-01-01'),
(4, 20, '2026-12-01');

INSERT INTO stockLog(productID, changeType, quantity) VALUES
(1, 'IN', 50),
(4, 'IN', 20);

INSERT INTO Tests(testName, testDescr, price) VALUES
('Blood Test', 'Basic blood test', 300),
('X-Ray', 'X-ray imaging', 800);

INSERT INTO LabReports(appointmentId, reportDate, reportStatus) VALUES
(2, '2026-04-30', 'Completed');

INSERT INTO ReportItems(reportId, testId, result) VALUES
(1, 1, 'Normal'),
(1, 2, 'Minor fracture');
SELECT * FROM users;
SELECT * FROM products;
select * from inventory;



-- lab 4
SET @@SQL_SAFE_UPDATES = 0;
UPDATE products SET price = 550 WHERE productID = 1;
SELECT productID, proName, price FROM products WHERE productID = 1;

UPDATE appointments SET appointmentStatus = 'Completed' WHERE appointmentID = 1;
SELECT appointmentID, appointmentStatus FROM appointments;

UPDATE orders SET orderStatus = 'Delivered' WHERE orderID = 1;

UPDATE inventory SET quantity = quantity - 1 WHERE productID = 1;

UPDATE products SET price = price + (price * 0.10);

DELETE FROM cart_items WHERE cartItemID = 2;
SELECT * FROM cart_items;

DELETE FROM products WHERE price < 200;

-- DELETE FROM users WHERE userID = 3;

UPDATE users SET userName = 'Heer Mehta',email = 'heer_new@gmail.com' WHERE userID = 1;

UPDATE pets SET petName = 'Bruno Max',breed = 'Golden Retriever' WHERE petID = 1;

ALTER TABLE pets ADD dateOfBirth DATE;
UPDATE pets SET dateOfBirth = '2021-05-10' WHERE petID = 1;
UPDATE pets SET dateOfBirth = '2022-03-15' WHERE petID = 2;
SELECT petName, TIMESTAMPDIFF(YEAR, dateOfBirth, CURDATE()) AS age FROM pets;



-- lab 5
SELECT * FROM users WHERE userName LIKE 'H%';
SELECT * FROM products WHERE catID IN (1, 4);
SELECT * FROM products WHERE price BETWEEN 200 AND 500;

SELECT * FROM orders o
WHERE EXISTS (
    SELECT 1 FROM orderItems oi
    WHERE o.orderID = oi.orderID
);

SELECT * FROM products p
WHERE EXISTS (
    SELECT 1 FROM inventory i
    WHERE p.productID = i.productID
);


-- lab 6
SELECT proName, price
FROM products
wHERE price > (SELECT AVG(price) FROM products);

SELECT proName
FROM products
WHERE productID IN (
    SELECT productID FROM inventory
);

SELECT proName,
CASE
    WHEN price < 200 THEN 'Cheap'
    WHEN price BETWEEN 200 AND 500 THEN 'Medium'
    ELSE 'Expensive'
END AS category
FROM products;

SELECT proName,
CASE 
    WHEN price < 200 THEN 'Cheap'
    WHEN price BETWEEN 200 AND 500 THEN 'Medium'
    ELSE 'Expensive'
END AS price_category
FROM products;

SELECT appointmentID,
CASE 
    WHEN appointmentStatus = 'Completed' THEN 'Done'
    WHEN appointmentStatus = 'Scheduled' THEN 'Upcoming'
    ELSE 'Other'
END AS status_label
FROM appointments;

SELECT orderID,
CASE 
    WHEN orderStatus = 'Delivered' THEN 'Completed Order'
    WHEN orderStatus = 'Ordered' THEN 'Processing'
    ELSE 'Other'
END AS order_state
FROM orders;

SELECT proName,
CASE 
    WHEN productID IN (SELECT productID FROM inventory) 
    THEN 'In Stock'
    ELSE 'Out of Stock'
END AS stock_status
FROM products;



-- 7
SELECT u.userName, o.orderID, o.totalAmt
FROM users u
INNER JOIN orders o ON u.userID = o.userID;
SELECT p.proName, c.catName
FROM products p
JOIN categories c ON p.catID = c.catID;
SELECT c.cartID, p.proName, ci.quantity
FROM cart c
JOIN cart_items ci ON c.cartID = ci.cartID
JOIN products p ON ci.productID = p.productID;
SELECT p.proName, IFNULL(i.quantity, 0) AS stock
FROM products p
LEFT JOIN inventory i ON p.productID = i.productID;
SELECT pt.petName, u.userName AS doctorName, a.appointmentDate
FROM appointments a
JOIN pets pt ON a.petID = pt.petID
JOIN doctors d ON a.doctorID = d.doctorID
JOIN users u ON d.userID = u.userID;
SELECT o.orderID, p.proName, oi.quantity
FROM orders o
JOIN orderItems oi ON o.orderID = oi.orderID
JOIN products p ON oi.productID = p.productID;
SELECT * FROM appointments
WHERE DATE(appointmentDate) = CURDATE();
SELECT orderID,
DATEDIFF(CURDATE(), orderDate) AS days_passed
FROM orders;
SELECT orderID,
MONTH(orderDate) AS month,
YEAR(orderDate) AS year
FROM orders;
SELECT p.productID, p.proName, IFNULL(i.quantity, 0) AS stock
FROM products p
LEFT JOIN inventory i ON p.productID = i.productID;

