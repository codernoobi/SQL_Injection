# SQL_Injection

This repo consists of 2 files(HTML, PHP) and explanation which would help in demonstrating SQL Injection attack and a prevention in local setup.
Follow the steps to execute the demo.

---
---
### Set up


Download Wamp

Once downloaded and installed check C drive for wamp64 folder which would contian dependencies.

Wamp internally installs PHP and MySQL required fro the execution

Apart from Wamp other servers like Apache, Xamp can be installed. Make sure to install MySQL and PHP for respective setups.

This example will follow Wamp

---
---
### Creating DB artifacts


Once successfully installing Wamp, open wampserver.exe to start wamp (in C drive wamp64 folder) then open the localhost to see wamp dash board.

localhost:8080/phpmyadmin (if asked for login user: root password is blank by default) would open PHP dashboard where a DB and respective artifacts can be created

Create DB in the UI with name SQL_INJECTION_EXAMPLE

To create a table use below command or use the UI directly
>create table user_details(
>
>user_id varchar(16),
>
>password varchar(600),
>
>email varchar(30),
>
>name varchar(30)
>
>);

---
---
### Insertion to DB


There are 2 approaches we will exlpore in this project
1. normal insertion

INSERT INTO `user_details`(`user_id`, `password, `email`, `name`) VALUES ([value-1],[value-2],[value-3],[value-4])
Password is directly inserted as text

2. insertion with encryption

INSERT INTO 'user_details' (`user_id`, `password, `email`, `name`) VALUES ([value-1], SHA2(CONCAT('$password','$user_id'),512) ,[value-3],[value-4])
Password is encrypted using SHA2

Insert multiple records with both commands

---
---
### App creation
Copy the .html and .php file in this repo to c:/wamp64/www/sqlInj/ (create a new folder with desired name like sqlInj)

---
---
### Code Explanation
HTML file is a simple form with 2 input fields(user_id, password) and a button(submit).

PHP file contains logic

>$host="localhost";
>
>$username="root";
>
>$password="";
>
>$db_name="SQL_INJECTION_EXAMPLE";
>
>$conn=new mysqli($host,$username,$password,$db_name);

This block of code establishes a connection with the db created in previous steps

---
>$uid = $_POST['uid'];
>
>$pid = $_POST['passid'];
>	
>//INSERT INTO user_details (user_id, password) VALUES ('$user_id', SHA2(CONCAT('$password','$user_id'),512))
>
>//$result = $conn->query("SELECT * FROM user_details WHERE user_id = '$uid' AND password = SHA2(CONCAT('$pid','$uid'),512)");
>
>$result = $conn->query("select * from user_details where user_id = '$uid' and password = '$pid'" );

This block of code queries db for a record based on login credentials

---
>
>if($result->num_rows == 1){
>
>echo "<h4>"."-- Personal Information -- "."</h4>","</br>";
>
>while ($row = $result->fetch_assoc()){
>
>echo "id: " . $row["user_id"]. "<br>Name: " . $row["fname"]. " " . $row["lname"]. "<br>Email: " . $row["email"]. "<br>";
>
>echo "--------------------------------------------<br>";
>
>}
>
>}else echo "Invalid user id or password";

This block prints user details if it is valid login

---
---
### Execution
#### Demo
Once the files are copied to the specified location refresh the wamp dashboard in localhost

The newely created folder will be availabe under Your Projects. open localhost/sqlInj in new tab to see the list of files in the folder

Open the .html file


A login form will open in a new tab

Use valid user_id and password of the record inserted using normal insertion(mentioned in insertion to db block)

Successful login will give the users personal info in a new page (true for all scenarios mentioned below)


1: Now for the same user try using **anything' or 'x' = 'x** as password

This would give personal information of all the users in db


2: In the .php file line 26 change the if condition from >0 to ==1 save the file.

Reopen the html file in browser

Now try with the password **anything' or 'x' = 'x** again

This would fail as the result would render multiple records

But the attacker was able to trigger the select query in php file

Now try with the password **x' = 'x** for the same user

This would give the personal information of the user


3: In .php file uncomment line 23 and comment line 24 save the file

Reopen the html file in the browser

Now try logging in with valid user_id and password of the record inserted using insertion with encryption(mentioned in insertion to db block)

Successful login will give the users personal info in a new page

Now try with passwords **anything' or 'x' = 'x** or **x' = 'x**

This would fail with invalid user error

---
---

### Conclusion:
Avoiding SQL Injection 

Best coding practices like using ==1 for preventing attacker from viewing multiple user information at once, but the data is still vulnerable.

using actions on input like encryption before insertion, using escape sequence on inputs, using stored procedures and not using dynamic queries etc will prevent data leak for some extension

For more understanding read about SQL Injection

