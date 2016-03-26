<?php
if ($_GET['randomId'] != "_OOJn_vH3du1CEvgjtOD4YBKDgXvCUcWv0k0SIaNgFXcQltyFrnEYy7ybGtUsfoJ") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
