<?php
require_once('bootstrap.php');
require_once('dataProvider.php');
require_once('My_Form_TaskWeek.php');

// create form & validate
$Form = new My_Form_TaskWeek();
$Form->setDefaults($storedTasks);

//var_dump($_POST['tasks']);
//if (isset($_POST['tasks']) && count($_POST['tasks'])>0) {
//    $isValid = $Form->isValid($_POST['tasks']);
//    // and if valid, do the necc. processing
//}
if (isset($_POST) && count($_POST)>0) {
    $isValid = $Form->isValid($_POST);
    // and if valid, do the necc. processing
}
//header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
    <head>
        <title>Zend_Form_Dynamic</title>
        <link rel="stylesheet" type="text/css" href="zend_form.css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.dynamicform.js"></script>
        <script type="text/javascript">
$(document).ready(function() {
    $('form .taskDay').dynamicForm();
});
        </script>
    </head>
    <body>

<?php
echo $Form->render();

echo '<pre>';
var_dump($Form->getValues());
echo '</pre>';
?>

    </body>
</html>