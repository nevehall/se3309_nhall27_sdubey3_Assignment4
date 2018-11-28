<?php require "../templates/header.php"; ?>

<?php
/**
 * View the number of skis in each brand.
 *
 */
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT b.brandName, COUNT(*)
                    FROM Ski s, Product p, Brand b
                    WHERE s.productNo = p.productNo AND p.brandID = b.brandID
                    GROUP BY brandName";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
?>
        
<h2>Ski Inventory in each Brand</h2>
<a href="./skiInfo.php">Back to Ski Info</a>
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