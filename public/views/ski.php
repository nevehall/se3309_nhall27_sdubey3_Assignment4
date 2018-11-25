<?php require "../templates/header.php"; ?>
<?php
/**
 * List all skis available at the store, either purchasable or rentable
 */
require "../../config.php";
require "../../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT * FROM Ski";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Skis</h2>

<table>
    <thead>
        <tr>
            <th>Product Number</th>
            <th>Level of Difficulty</th>
            <th>Length</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["productNo"]); ?></td>
            <td><?php echo escape($row["difficultyRank"]); ?></td>
            <td><?php echo escape($row["length"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>