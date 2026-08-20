<?php if (isset($_SESSION['error'])){ ?>
    <p align ="center" dir="rtl" id="btn"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php }
if(isset($_SESSION['ok'])){ ?>
    <p align ="center" id="ok"><?php echo $_SESSION['ok']; unset($_SESSION['ok']);?></p>
<?php } ?>