<?php require "../templates/header.php"; ?>

<?php
/**
 * View the number of snowboards in each brand.
 *
 */
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT b.brandName, COUNT(*)
                    FROM Snowboard s, Product p, Brand b
                    WHERE s.productNo = p.productNo AND p.brandID = b.brandID
                    GROUP BY brandName";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
?>
        
<h2>Snowboard Inventory in each Brand</h2>
<a href="./snowboardInfo.php">Back to Snowboard Info</a>
<link rel="stylesheet" type="text/css" href="../css/style.css">


<table>
    <thead>
        <tr>
            <th>Number</th>
            <th>Brand Name</th>
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["COUNT(*)"]); ?></td>
            <td><?php echo escape($row["brandName"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>