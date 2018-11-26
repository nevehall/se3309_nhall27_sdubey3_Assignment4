<?php require "../templates/header.php"; ?>

<?php
/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */
if (isset($_POST['submit'])) {
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT * 
                        FROM Transactions
                        WHERE employeeNo = :employeeNo";
        $employeeNo = $_POST['employeeNo'];
        $statement = $connection->prepare($sql);
        $statement->bindParam(':employeeNo', $employeeNo, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
        
<?php  
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Customer</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["transactionID"]); ?></td>
                <td><?php echo escape($row["transTime"]); ?></td>
                <td><?php echo escape($row["transDate"]); ?></td>
                <td><?php echo escape($row["total"]); ?></td>
                <td><?php echo escape($row["customerEmail"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['employeeNo']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find Employee Transaction History</h2>

<form method="post">
    <label for="employeeNo">Employee No </label>
    <input type="text" id="employeeNo" name="employeeNo">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="../transactions.php">Back to Transaction Info</a>

<?php require "../templates/footer.php"; ?>