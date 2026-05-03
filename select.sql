USE vetmanagement;

-- USER & ROLE
SELECT * FROM roles;
SELECT * FROM users;
SELECT * FROM user_phones;
SELECT * FROM user_roles;

-- CATEGORY & PRODUCTS
SELECT * FROM categories;
SELECT * FROM products;

-- PET & CLINIC
SELECT * FROM pets;
SELECT * FROM doctors;
SELECT * FROM appointments;

-- PRESCRIPTIONS
SELECT * FROM prescriptions;
SELECT * FROM prescriptionItems;

-- CART & ORDERS
SELECT * FROM cart;
SELECT * FROM cart_items;
SELECT * FROM addresses;
SELECT * FROM orders;
SELECT * FROM orderItems;
SELECT * FROM payments;
SELECT * FROM deliveries;

-- SERVICES & GROOMING
SELECT * FROM services;
SELECT * FROM beauticians;
SELECT * FROM beauticianSchedule;
SELECT * FROM serviceBookings;
SELECT * FROM serviceAssign;

-- INVENTORY
SELECT * FROM inventory;
SELECT * FROM stockLog;

-- LAB
SELECT * FROM Tests;
SELECT * FROM LabReports;
SELECT * FROM ReportItems;