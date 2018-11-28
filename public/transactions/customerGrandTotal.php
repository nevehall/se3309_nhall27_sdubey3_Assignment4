<?php require "../templates/header.php"; ?>

<?php
/**
 * View grand total amount spent at the store by specified customer.
 *
 */

    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT customerEmail, SUM(total) AS grandTotal
                    FROM Transactions 
                    GROUP BY customerEmail";
        $customerEmail = $_POST['customerEmail'];
        $statement = $connection->prepare($sql);
        $statement->bindParam(':customerEmail', $customerEmail, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

?>

<link rel="stylesheet" type="text/css" href="../css/style.css">
<a href="../transactions.php">Back to Transactions</a>
<table>
    <thead>
        <tr>
            <th>Customer</th>
            <th>Grand Total</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) { ?>
        <tr>
            <td><?php echo escape($row["customerEmail"]); ?></td>
            <td><?php echo escape($row["grandTotal"]); ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
  