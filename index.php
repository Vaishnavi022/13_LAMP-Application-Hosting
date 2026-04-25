<?php
$host = "lamp-db.cd48wqmg2qf7.ap-south-1.rds.amazonaws.com";
$user = "admin";
$password = "YOUR_PASSWORD"; // 🔴 replace this
$db = "lampdb";

$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ADD USER
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
}

// DELETE USER
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
}

// FETCH DATA
$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>LAMP CRUD App</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            padding: 30px;
        }
        h2, h3 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 70%;
            margin-bottom: 20px;
            background: white;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background: #78A2D2;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        form input {
            padding: 10px;
            margin: 5px;
            width: 200px;
        }
        button {
            padding: 10px 20px;
            background: #78A2D2;
            border: none;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #5c85b3;
        }
        .delete {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>User Data</h2>

<table>
<tr>
    <th>No.</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php 
$serial = 1;
while($row = $result->fetch_assoc()) { 
?>
<tr>
    <td><?php echo $serial++; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td>
        <a class="delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this user?')">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

<h3>Add New User</h3>

<form method="POST">
    <input type="text" name="name" placeholder="Enter Name" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <button type="submit" name="add">Add User</button>
</form>

</body>
</html>

<?php
$conn->close();
?>
