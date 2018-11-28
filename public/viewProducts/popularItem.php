<?php require "../templates/header.php"; ?>

<?php
/**
 * View the number of skis and snowboards available in each brand.
 *
 */
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = /*"SELECT s.productNo, w.productNo, h.productNo, b.productNo, 
                COUNT(s.productNo), COUNT(w.productNo), COUNT(h.productNo), COUNT(b.productNo)
                    FROM Transactions t, Product p, Item i, Ski s, Snowboard w, 
                        Helmet h, Boots b
                    WHERE t.transactionID = i.transactionID
                    AND i.productNo = p.productNo
                    AND p.productNo = s.productNo
                    AND p.productNo = w.productNo
                    AND p.productNo = h.productNo
                    AND p.productNo = b.productNo
                GROUP BY s.productNo, w.productNo, h.productNo, b.productNo";*/
                "(SELECT COUNT(s.productNo)
                FROM Transactions t, Item i, Product p, Ski s
                WHERE t.transactionID = i.transactionID 
                	AND i.productNo = p.productNo 
                    AND p.productNo = s.productNo
                    AND t.transDate > '2018-01-01')
                UNION 
                (SELECT COUNT(w.productNo)
                FROM Transactions t, Item i, Product p, Snowboard w
                WHERE t.transactionID = i.transactionID 
                	AND i.productNo = p.productNo 
                    AND p.productNo = w.productNo
                    AND t.transDate > '2018-01-01')
                UNION
                (SELECT COUNT(h.productNo)
                FROM Transactions t, Item i, Product p, Helmet h
                WHERE t.transactionID = i.transactionID 
                	AND i.productNo = p.productNo 
                    AND p.productNo = h.productNo
                    AND t.transDate > '2018-01-01')
                UNION
                (SELECT COUNT(b.productNo)
                FROM Transactions t, Item i, Product p, Boots b
                WHERE t.transactionID = i.transactionID 
                	AND i.productNo = p.productNo 
                    AND p.productNo = b.productNo
                    AND t.transDate > '2018-01-01')";
                
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
?>
        
<h2>Product Statistics</h2>
<p>Below displays a count of each product sold in the year 2018.</p>
<a href="../viewProducts.php">Back to views</a>

<link rel="stylesheet" type="text/css" href="../css/style.css">


<table>
    <thead>
        <tr>
            <th>Skis</th>
            <th>Snowboards</th>
            <th>Helmets</th>
            <th>Boots</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : 
            echo "<tr>";
            for($col = 0; $col < 4; $col ++) { 
            echo "<td>"; echo escape($row["COUNT(s.productNo)"]); echo "</td>";
            echo "<td>"; echo escape($row["COUNT(w.productNo)"]); echo "</td>";
            echo "<td>"; echo escape($row["COUNT(h.productNo)"]); echo "</td>";
            echo "<td>"; echo escape($row["COUNT(b.productNo)"]); echo "</td>";
            }
            echo "</tr>"; ?>
    <?php endforeach; ?>
    </tbody>
</table>

