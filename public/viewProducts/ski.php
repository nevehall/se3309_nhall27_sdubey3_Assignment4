<?php require "../templates/header.php"; ?>
<?php
/**
 * List all skis available at the store
 */
require "../../config.php";
require "../../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql ="SELECT s.productNo, s.difficultyRank, s.length, p.price, b.brandName
        FROM Ski s, Product p, Brand b
        WHERE p.productNo = s.productNo AND b.brandID = p.brandID";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<link rel="stylesheet" type="text/css" href="../css/style.css">

<h2>Skis</h2>
<a href="../viewProducts/skiInfo.php">Back to Ski Info</a>

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
