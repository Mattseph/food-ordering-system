CREATE TABLE deleted_admin_list (
	admin_id INT NOT NULL AUTO_INCREMENT,
    lastname VARCHAR(100) NOT NULL,
    firstname VARCHAR(100) NOT NULL,
	username VARCHAR(100) NOT NULL,
	password varchar(100) NOT NULL,
    date_deleted datetime NOT NULL,
	PRIMARY KEY(admin_id)
);

CREATE TABLE deleted_users (
	user_id int NOT NULL AUTO_INCREMENT,
    user_lastname varchar(100) NOT NULL,
    user_firstname varchar(100) NOT NULL,
    user_username varchar(50) NOT NULL,
    user_email varchar(100) NOT NULL,
    user_phonenumber varchar(100) NOT NULL,
    date_deleted datetime NOT NULL,
    PRIMARY KEY(user_id)
);

CREATE TABLE deleted_suppliers (
	supplier_id int NOT NULL AUTO_INCREMENT,
    supplier_lastname varchar(50) NOT NULL,
    supplier_firstname varchar(50) NOT NULL,
    contact_number int(11) NOT NULL,
    email varchar(100) NOT NULL,
    address varchar(100) NOT NULL,
    country varchar(50) NOT NULL,
    postal_code varchar(50) NOT NULL,
    active varchar(10) NOT NULL,
    date_deleted datetime NOT NULL,
    PRIMARY KEY(supplier_id)
);

CREATE TABLE deleted_category_list (
	category_id int NOT NULL AUTO_INCREMENT,
    category_name varchar(100) NOT NULL,
    image_name varchar(100) NOT NULL,
    active varchar(10) NOT NULL,
    date_deleted datetime NOT NULL,
    PRIMARY KEY(category_id)
);
CREATE TABLE deleted_food_list (
	food_id int NOT NULL AUTO_INCREMENT,
    category_id INT NOT NULL,
    supplier_id int NOT NULL,
    food_name varchar(100) NOT NULL,
    description varchar(255) NOT NULL,
    food_price decimal(10,2) NOT NULL,
    image_name varchar(100) NOT NULL,
    active varchar(10) NOT NULL,
    PRIMARY KEY(food_id),
    date_deleted datetime NOT NULL,
    FOREIGN KEY(category_id) REFERENCES deleted_category_list(category_id),
    FOREIGN KEY(supplier_id) REFERENCES deleted_suppliers(supplier_id)
);


CREATE TABLE deleted_delivery_rider (
	rider_id int NOT NULL AUTO_INCREMENT,
    rider_lastname varchar(50) NOT NULL,
    rider_firstname varchar(50) NOT NULL,
    contact_number int NOT NULL,
    email varchar(100) NOT NULL,
    active varchar(45) NOT NULL,
    date_deleted datetime NOT NULL,
    PRIMARY KEY(rider_id)
);


CREATE TABLE deleted_order_details (
	order_id varchar(100) NOT NULL,
    customer_lastname varchar(100) NOT NULL,
    customer_firstname varchar(100) NOT NULL,
    contact_number int(11) NOT NULL,
    delivery_address varchar(255) NOT NULL,
    postalcode varchar(50) NOT NULL,
    rider_id int NOT NULL,
    food_id int NOT NULL,
    quantity decimal(10, 2) NOT NULL,
    total decimal(10, 2) NOT NULL,
    mode_of_payment varchar(50) NOT NULL,
    order_date datetime NOT NULL,
    expected_delivery datetime NOT NULL,
    status varchar(45) NOT NULL,
    PRIMARY KEY(order_id),
    date_deleted datetime NOT NULL,
    FOREIGN KEY(rider_id) REFERENCES deleted_delivery_rider(rider_id),
    FOREIGN KEY(food_id) REFERENCES deleted_food_list(food_id)
);

CREATE TABLE deleted_messages (
	message_id int NOT NULL AUTO_INCREMENT,
    user_id int NOT NULL,
    message varchar(255) NOT NULL,
    date_message datetime NOT NULL,
    PRIMARY KEY(message_id),
    date_deleted datetime NOT NULL,
    FOREIGN KEY(user_id) REFERENCES deleted_users(user_id)
);

CREATE VIEW family_meal AS
SELECT food_name, food_price
FROM deleted_food_list
WHERE food_price >= 5;

CREATE VIEW budget_meal AS
SELECT food_name, food_price
FROM deleted_food_list
WHERE food_price < 5;




