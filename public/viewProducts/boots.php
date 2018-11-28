<?php require "../templates/header.php"; ?>
<?php
/**
 * List all boots available at the store
 */
require "../../config.php";
require "../../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT b.productNo, p.size, p.price, r.brandName
        FROM Boots b, Product p, Brand r
        WHERE p.productNo = b.productNo AND r.brandID = p.brandID";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Boots</h2>
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
<link rel="stylesheet" type="text/css" href="../css/style.css">


<?php require "../templates/footer.php"; ?>