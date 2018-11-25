<?php require "../templates/header.php"; ?>
<?php
/**
 * List all snowboards available at the store
 */
require "../../config.php";
require "../../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT s.productNo, s.difficultyRank, s.length, p.price, b.brandName
        FROM Snowboard s, Product p, Brand b
        WHERE p.productNo = s.productNo AND b.brandID = p.brandID";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Snowboards</h2>
<a href="../viewProducts.php">Back to views</a>

<table>
    <thead>
        <tr>
            <th>Product Number</th>
            <th>Level of Difficulty</th>
            <th>Length</th>
            <th>Price</th>
            <th>Brand</th>
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["productNo"]); ?></td>
            <td><?php echo escape($row["difficultyRank"]); ?></td>
            <td><?php echo escape($row["length"]); ?></td>
            <td><?php echo escape($row["price"]); ?></td>
            <td><?php echo escape($row["brandName"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php require "../templates/footer.php"; ?>