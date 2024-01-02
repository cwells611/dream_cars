use cwells; 

DROP TABLE IF EXISTS orders; 
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS product;

CREATE TABLE customer (
    id int NOT NULL AUTO_INCREMENT,
    first_name varchar(255), 
    last_name varchar(255), 
    email varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE product (
    id int NOT NULL AUTO_INCREMENT,
    product_name varchar(255), 
    image_name varchar(255), 
    price decimal(9,2), 
    in_stock int,
    inactive TINYINT,
    PRIMARY KEY (id)
);

CREATE TABLE orders (
    id int NOT NULL AUTO_INCREMENT,
    product_id int, 
    customer_id int, 
    quantity int, 
    price decimal(9,2),
    tax decimal(6,2),
    donation decimal(4,2), 
    timestamp bigint,
    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);

CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    first_name varchar(255), 
    last_name varchar(255), 
    password varchar(255),
    email varchar(255),
    role int,
    PRIMARY KEY (id)
);

INSERT INTO customer (first_name, last_name, email)
VALUES ('Mickey', 'Mouse', 'mmouse@mines.edu'); 
INSERT INTO customer (first_name, last_name, email)
VALUES ('Caden', 'Wells', 'cwells@mines.edu'); 

INSERT INTO product (product_name, image_name, price, in_stock, inactive)
VALUES ('Porsche 911 GT3 RS', 'gt3.jpg', 240300.50, 0, 0); 
INSERT INTO product (product_name, image_name, price, in_stock, inactive)
VALUES ('Acura NSX', 'nsx.jpg', 171495.12, 5, 0);
INSERT INTO product (product_name, image_name, price, in_stock, inactive)
VALUES ('Datsun 240Z', '240z.jpg', 80000.99, 10, 0); 
INSERT INTO product (product_name, image_name, price, in_stock, inactive)
VALUES('Pagani Huayra', 'huayra.jpg', 3400000.64, 2, 0); 

INSERT INTO users (first_name, last_name, password, email, role)
VALUES ('Frodo', 'Baggins', 'fb', 'fb@mines.edu', 1);
INSERT INTO users (first_name, last_name, password, email, role)
VALUES ('Harry', 'Potter', 'hp', 'hp@mines.edu', 2);