<link rel="stylesheet" type="text/css" href="../css/style.css">

<?php require "../templates/header.php"; ?>
<?php
/**
 * Search ski difficulty rank.
 */
require "../../config.php";
require "../../common.php";
if (isset($_POST['submit'])) {
    try {
            $connection = new PDO($dsn, $username, $password, $options);
            $sql ="SELECT s.difficultyRank, s.length, b.brandName, p.productNo
                        FROM Ski s, Product p, Brand b
                        WHERE difficultyRank = :difficultyRank
                        AND s.productNo = p.productNo
                        AND p.brandID = b.brandID";
            $difficultyRank = $_POST['difficultyRank'];
            $statement = $connection->prepare($sql);
            $statement->bindParam(':difficultyRank', $difficultyRank, PDO::PARAM_STR);
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
                    <th>Ski No</th>
                    <th>Length</th>
                    <th>Brand</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["productNo"]); ?></td>
                <td><?php echo escape($row["length"]); ?></td>
                <td><?php echo escape($row["brandName"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['difficultyRank']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find ski based on difficultyRank</h2>

<form method="post">
    <label for="difficultyRank">Difficulty Rank (1,2,3): </label>
    <input type="text" id="difficultyRank" name="difficultyRank">
    <input type="submit" name="submit" value="View Results">
</form>

<link rel="stylesheet" type="text/css" href="../css/style.css">

<a href="../viewProducts.php">Back to Product Info</a>


<?php require "../templates/footer.php"; ?>
