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
        /*$sql = "SELECT b.brandName, s.COUNT(*), w.COUNT(*)
                    FROM Ski s, Product p, Brand b, Snowboard w
                    WHERE s.productNo = p.productNo AND w.productNo = p.productNo
                        AND p.brandID = b.brandID
                    GROUP BY b.brandName";*/
                    
        /*$sql = "SELECT b.brandName
                        (SELECT COUNT(*)
                            FROM Ski s, Product p, Brand b) AS skiTotal,
                        (SELECT COUNT(*)
                        FROM Snowboard w, Product p, Brand b) AS snowTotal
                    WHERE s.productNo = p.productNo
                    AND w.productNo = p.productNo 
                    AND p.brandID = b.brandID
                    GROUP BY b.brandName";*/
                    
        $sql = "SELECT skiCount, snowCount
                    COUNT(s.productNo) AS skiCount,
                    COUNT(w.productNo) AS snowCount
                FROM Ski s, Snowboard w, Product p, Brand b
                RIGHT JOIN Brand b ON p.brandID = b.brandID
                AND s.productNo = p.productNo
                AND w.productNo = b.productNo
                ORDER BY b.brandName";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
?>
        
<h2>Product Statistics</h2>
<p>Below displays how many of each item has sold in the specified brand in all store history.</p>
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
            <td><?php echo escape($row["skiCount"]); ?></td>
            <td><?php echo escape($row["snowCount"]); ?></td>
            <td><?php echo escape($row["brandName"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>