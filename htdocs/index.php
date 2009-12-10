<?php
require_once('bootstrap.php');
require_once('My_Form_Hours.php');
require_once('My_Form_Renderer_Hour.php');


$hoursData = array(
    array( 'id' => 11, 'desc' => 'line1', 'h' => 8, 'm' => 0),
    array( 'id' => 12, 'desc' => 'line2', 'h' => 5, 'm' => 15),
);

// create form & validate
$Form = new My_Form_Hours();
$Form->setData($hoursData);


if (isset($_POST) && count($_POST)>0) {
    $isValid = $Form->isValid($_POST);
} else {
    // initial state -> populate with defaults
}

// display page
//header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
    <head>
        <title>Zend_Form demo</title>
        <link rel="stylesheet" type="text/css" href="zend_form.css" />
        <script type="text/javascript" src="jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="dynamicForm.js"></script>
    </head>
    <body>

<button id="add">add</button>
<?php
$RendererEdit = new My_Form_Renderer_Hour($Form, 'user_edit');
echo $RendererEdit->render();

echo '<pre>';
var_dump($Form->getValues());
echo '</pre>';

?>

    </body>
</html>