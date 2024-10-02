CREATE DATABASE IF NOT EXISTS development;

USE development;

CREATE TABLE IF NOT EXISTS items (
    number INT PRIMARY KEY,
    name VARCHAR(255),
    bottlesize VARCHAR(10),
    price DECIMAL(10, 2),
    pricegbp DECIMAL(10, 2),
    retrieved TIMESTAMP,
    orderamount INT
);
