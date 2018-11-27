<?php require "../templates/header.php"; ?>
<?php
/**
 * Delete a user
 */
require "../../config.php";
require "../../common.php";
if (isset($_GET["customerEmail"])){ 
  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $customerEmail = $_GET["customerEmail"];
    $sql ="DELETE 
            FROM Customer
            WHERE customerEmail = :customerEmail";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':customerEmail', $customerEmail);
    $statement->execute();
    $success = "User successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql ="SELECT * FROM Customer";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
        
<h2>Delete users</h2>
<a href="../viewCustomers.php">Back to Customer Info</a>


<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
        <th>Email Address</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Customer Phone</th>
        <th>Height (cm)</th>
        <th>Weight (lbs)</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
        <td><?php echo escape($row["customerEmail"]); ?></td>
        <td><?php echo escape($row["fname"]); ?></td>
        <td><?php echo escape($row["lname"]); ?></td>
        <td><?php echo escape($row["customerPhone"]); ?></td>
        <td><?php echo escape($row["height"]); ?></td>
        <td><?php echo escape($row["weight"]); ?></td>
      <td><a href="delete.php?customerEmail=<?php echo escape($row["customerEmail"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>


<?php require "../templates/footer.php"; ?>