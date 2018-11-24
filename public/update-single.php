<?php
/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
    if(!function_exists('hash_equals')){
        function hash_equals($str1, $str2){
            if(strlen($str1) != strlen($str2)){
                return false;
            }
            else
            {
                $res = $str1 ^ $str2;
                $ret = 0;
                for($i = strlen($res) - 1; $i >= 0; $i--)
                {
                    $ret |= ord($res[$i]);
                }
                return !$ret;
            }
        }
    }   
    
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $customer =[
        "customerEmail" => $_POST['customerEmail'],
        "fname" => $_POST['fname'],
        "lname"  => $_POST['lname'],
        "customerPhone" => $_POST['customerPhone'],
        "height" => $_POST['height'],
        "weight" => $_POST['weight']
    ];
    $sql = "UPDATE Customer
            SET customerEmail = :customerEmail, 
              fname = :fname, 
              lname = :lname, 
              customerPhone = :customerPhone, 
              height = :height, 
              weight = :weight 
            WHERE customerEmail = :customerEmail";
  
  $statement = $connection->prepare($sql);
  $statement->execute($customer);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['customerEmail'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $customerEmail = $_GET['customerEmail'];
    $sql = "SELECT * FROM Customer WHERE customerEmail = :customerEmail";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':customerEmail', $customerEmail);
    $statement->execute();
    
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['fname']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a customer</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($customer as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?> 
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

