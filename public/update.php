<?php require "templates/header.php"; ?>
<?php
/**
 * List all customers with a link to edit
 */
require "../config.php";
require "../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT * FROM Customer";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
        
<h2>Update customers</h2>

<table>
    <thead>
        <tr>
            <th>Email Address</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Customer Phone</th>
            <th>Height</th>
            <th>Weight</th>
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
            <td><a href="update-single.php?customerEmail=<?php echo escape($row["customerEmail"]); ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>