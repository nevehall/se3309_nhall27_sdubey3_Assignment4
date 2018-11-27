<?php require "../templates/header.php"; ?>

<?php
/**
 * View the number of products sold from each brand in the past year.
 *
 */
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT b.brandName, COUNT(*)
                    FROM Transactions t, Product p, Item i, Brand b
                    WHERE t.transactionID = i.transactionID 
                        AND i.productNo = p.productNo 
                        AND p.brandID = b.brandID
                        AND t.transDate > '2018-01-01'
                    GROUP BY b.brandName";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
?>
        
<h2>Brand Statistics</h2>
<p>Below displays the number of items sold in each brand in the past year.</p>
<a href="../viewProducts.php">Back to views</a>

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