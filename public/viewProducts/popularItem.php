<?php require "../templates/header.php"; ?>

<?php
/**
 * Products stats.
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
                    
        $sql .=    "SELECT b.brandName, COUNT(*)
                    FROM Ski s, Product p, Brand b
                    WHERE s.productNo = p.productNo AND p.brandID = b.brandID
                    GROUP BY brandName";
        $statement = $connection->prepare($sql);
        //$statement = $connection->prepare($sql .);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
        //echo $sql . "<br>" . $error->getMessage();
    }
?>
        
<h2>Product Statistics</h2>
<p>Below displays the number of items sold in each brand in the past year.</p>
<a href="../viewProducts.php">Back to views</a>

<table>
    <thead>
        <tr>
            <th>Skis</th>
            <th>Snowboards</th>
            <th>Brand</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["COUNT(*)"]); ?></td>
            <td><?php echo escape($row["COUNT(*)"]); ?></td>
            <td><?php echo escape($row["brandName"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>