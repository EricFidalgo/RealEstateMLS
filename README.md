# Real Estate MLS System

**[→ View Project Page](https://ericfidalgo.github.io/portfolio/projects/project.html?id=real-estate-mls)**

## Project Description

This project is a web-based Real Estate Multiple Listing Service (MLS) system. It uses PHP to connect to a MySQL database and provides a simple interface for managing property listings, agents, and buyers.

The core functionality includes:

  * **Listings Page**: Displays all available "House" and "Business Property" listings in separate tables, pulling data from multiple tables (Property, House, BusinessProperty, Listings).
  * **Agents Page**: Shows a list of all real estate agents and their affiliated firms.
  * **Buyers Page**: Shows a list of all registered buyers and their basic property preferences.
  * **Search Page**: Provides a form for users to search for houses based on minimum/maximum price, number of bedrooms, and number of bathrooms.
  * **Custom Query Page**: Offers a `textarea` for users to run their own custom `SELECT` queries against the database.

## Technologies Used

  * **Language:** PHP, SQL
  * **Database:** MySQL
  * **Core Libraries:** PHP `mysqli` extension
  * **Tools:** Web Server (e.g., Apache, Nginx)

## How to Run

1.  **Prerequisites**

      * A local web server environment like [XAMPP](https://www.apachefriends.org/index.html) or [MAMP](https://www.mamp.info/en/windows/) (which includes Apache, PHP, and MySQL).
      * Access to a MySQL database (e.g., via phpMyAdmin, which comes with XAMPP/MAMP).

2.  **Database Setup**

    1.  Start your Apache and MySQL services.
    2.  Open your database management tool (like phpMyAdmin) and import the `tables.sql` file. This will create the `RealEstate` database, define all the tables, and insert the sample data.

3.  **Application Setup**

    1.  Place the `final.php` file into your web server's root directory (e.g., `C:/xampp/htdocs/` on Windows for XAMPP).
    2.  You must update the username and password in `final.php` on line 11 & 12:
        ```php
        $username = "YOUR_USERNAME_HERE";
        $password = "YOUR_PASSWORD_HERE";
        ```

4.  **Execution**

    1.  Open your web browser.
    2.  Navigate to `http://localhost/final.php`.
    3.  You can navigate between the different sections using the links at the top of the page.

## Project Output

The application is a multi-page website. The main views are:

  * **Listings View**:

      * Displays a "House Listings" table with columns: MLS Number, Address, Owner, Price, Bedrooms, Bathrooms, Size.
      * Displays a "Business Property Listings" table with columns: MLS Number, Address, Owner, Price, Type, Size.

  * **Agents View**:

      * Displays an "Agents" table with columns: Agent ID, Name, Phone, Firm Name, Date Started.

  * **Buyers View**:

      * Displays a "Buyers" table with columns: Buyer ID, Name, Phone, Property Type, Preferences.

  * **Search View**:

      * Presents a form with inputs for Min Price, Max Price, Bedrooms, and Bathrooms.
      * Upon submission, it displays a "Search Results" table with matching houses or a "No houses found" message.
