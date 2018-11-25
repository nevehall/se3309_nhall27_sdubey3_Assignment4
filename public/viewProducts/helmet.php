<?php require "../templates/header.php"; ?>
<?php
/**
 * List all helmets available at the store
 */
require "../../config.php";
require "../../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT h.productNo, p.size, p.price, b.brandName
        FROM Helmet h, Product p, Brand b
        WHERE p.productNo = h.productNo AND b.brandID = p.brandID";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Helmets</h2>
<a href="../viewProducts.php">Back to views</a>
<table>
    <thead>
        <tr>
            <th>Product Number</th>
            <th>Size</th>
            <th>Price</th>
            <th>Brand</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["productNo"]); ?></td>
            <td><?php echo escape($row["size"]); ?></td>
            <td><?php echo escape($row["price"]); ?></td>
            <td><?php echo escape($row["brandName"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php require "../templates/footer.php"; ?>