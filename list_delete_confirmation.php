<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clear List Confirmation</title>
</head>

<body>
<p>Are you sure you wish to delete all items from the list?</p>
<form id="form1" name="form1" method="post">
  <p>
    <input name="submit" type="submit" id="submit" formaction="list_delete.php" value="Yes">
  </p>
  <p>
    <input name="submit2" type="submit" id="submit2" formaction="shopping_list.php" value="No, take me back">
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
