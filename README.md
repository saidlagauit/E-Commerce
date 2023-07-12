# E-Commerce - Tutorial

This is an e-commerce website built using PHP, MySQL, and Bootstrap. The website allows users to browse and purchase digital products online without the need for registration. The payment method is Cash on Delivery (COD).

## Technologies Used

- **PHP**: A server-side scripting language used for dynamic web development. It is used for handling backend logic, processing user requests, and interacting with the database.
- **MySQL**: A popular relational database management system used for storing and retrieving data. It is used for managing product information, user details, and order data.
- **Bootstrap**: A CSS framework that provides pre-built responsive components and styles. It is used for designing the website's user interface and ensuring a consistent layout across different devices.

## Features

- Product catalog: The website displays a catalog of digital products available for purchase. Each product includes details such as name, description, and price.
- Guest checkout: Users can add products to their cart and proceed to checkout without the need for registration or account creation.
- Cash on Delivery (COD): The payment method for the website is Cash on Delivery. Users can complete the purchase and make the payment when the product is delivered to them.
- Order processing: Once users proceed to checkout, the website generates an order summary and provides the option to select Cash on Delivery as the payment method.
- Order confirmation: After placing the order, users receive an order confirmation with the details of their purchase.
- Admin panel: An admin panel is available to manage products and view and process user orders. Admins have additional privileges to add, edit, and delete products.

## Getting Started

To set up the e-commerce website locally, follow these steps:

1. Clone the repository: `git clone https://github.com/saidlagauit/E-Commerce.git`
2. Set up a local web server (e.g., XAMPP, WAMP, or MAMP) and ensure PHP and MySQL are installed and configured.
3. Import the provided SQL file into your MySQL database to set up the necessary tables and sample data.
4. Place the project files in the web server's document root directory.
5. Configure the database connection by updating the database credentials in the PHP files.
6. Open your browser and visit the website's URL to view and interact with the e-commerce site.
7. Create new table contact used :
```sql
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` text NOT NULL DEFAULT 'none',
  `message` text NOT NULL,
  `created_c` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

## Contact

If you have any questions or feedback, feel free to contact us at lagauitsaid@hotmail.com.
