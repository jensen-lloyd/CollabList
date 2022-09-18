<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add category</title>
</head>

<body>
<h2>Add item category</h2>
<form id="form1" name="form1" method="post">
  <p>
    <label for="fvName">Name:</label>
    <input type="text" name="fvName" id="fvName">
  </p>
  <p>
    <input name="submit" type="submit" id="submit" formaction="edit_categories.php" value="Add">
    <input name="submit2" type="submit" id="submit2" formaction="edit_categories.php" value="Back to categories">
  </p>
</form>
</body>
</html