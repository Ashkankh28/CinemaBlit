<?php
session_start();
include("header.php");
if(isset($_POST['movname']) && !empty($_POST['movname'])){
$movname = $_POST['movname'];
$search = "%" . $movname . "%";
$stmt = mysqli_prepare($link, "SELECT * FROM movies WHERE movname LIKE ?");

mysqli_stmt_bind_param($stmt, "s", $search);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if($result && mysqli_num_rows($result) > 0){
?>
<table id="body" align="center" cellspacing="0">
<tr>
<?php
    $counter = 0;
    while($row = mysqli_fetch_array($result)) {
        if ($counter > 0 && $counter % 3 == 0) {
            echo '</tr><tr>';
        }
        ?>
        <td align="center" width="33%">
            <a style="display: inline-block;position: relative;width:100%;"
            href="moviep.php?movid=<?= e($row['movid']) ?>">
        <img id="movie" src="pics/<?= e($row['movpicture']) ?>" 
        alt="<?= e($row['movname']) ?>">
        <span id="overlay">:کارگردان<br/><?= e($row['movdirector']) ?></span></a><br>
            <p id="titr" style="font-size:1.05rem;font-weight:700;margin-top:.3rem;"><?= e($row['movname']) ?></p>
            <p id="lbl" style="color:var(--gold-soft);font-weight:600;"><?= e(number_format($row['movprice'])) ?> تومان</p>
        </td>
    <?php
        $counter++;
    }
    ?>
    </tr>
    </table>
<?php
    }
    else{
        $_SESSION['error'] = "فیلمی با این نام وجود ندارد";
        header("location: main-cinemablit.php");
        exit();
    }
    
    mysqli_stmt_close($stmt);
    
    }
    else{
        $_SESSION['error'] = "نام یک فیلم را وارد کنید";
        header("location: main-cinemablit.php");
        exit();
    }
include("footer.php");
?>