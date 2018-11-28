<?php require "../templates/header.php"; ?>

<?php
/**
 * Function to query information based on 
 * a parameter: in this case, filter skis available for
 * a customer's height and weight.
 *
 */
if (isset($_POST['submit'])) {
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT customerEmail, height, s.length, s.difficultyRank
                FROM Customer c, Snowboard s
                WHERE customerEmail = :customerEmail
                ORDER BY CASE WHEN s.length > c.height THEN difficultyRank = 1 END DESC
                        ,CASE WHEN s.length = c.height THEN difficultyRank = 2 END DESC
                        ,CASE WHEN s.length < c.height THEN difficultyRank = 3 END;
                GO";
        $customerEmail = $_POST['customerEmail'];
        $statement = $connection->prepare($sql);
        $statement->bindParam(':customerEmail', $customerEmail, PDO::PARAM_STR);
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
                    <th>Customer Email</th>
                    <th>Height</th>
                    <th>Snowboard Length</th>
                    <th>Difficulty Rank</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["customerEmail"]); ?></td>
                <td><?php echo escape($row["height"]); ?></td>
                <td><?php echo escape($row["length"]); ?></td>
                <td><?php echo escape($row["difficultyRank"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['customerEmail']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find Ski Options For Customer: </h2>

<form method="post">
    <label for="customerEmail">Customer Email</label>
    <input type="text" id="customerEmail" name="customerEmail">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="./snowboardInfo.php">Back to Ski Info</a>
<link rel="stylesheet" type="text/css" href="../css/style.css">

<?php require "../templates/footer.php"; ?>