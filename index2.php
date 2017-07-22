<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Web Scrape Yellow Pages</title>


<link href="css/style.css" rel="stylesheet" type="text/css">
  
</head>
<body>
<div><h1 class="header">Yellow Pages Web Scrape</h1></div>

<!--Sets the form to send the information to the create-csv.php script -->
<form action="create-csv2.php" method="post"  class="form-wrapper cf">

	URL:<input type="text" id="url" name="url" placeholder="url" size="150""required><br>
	Start Page:<input type="text" id="page" name="page" placeholder="page" size="10""required><br>
	Number of Business: <input type="text" id="number" name="number" placeholder="number" size="10""required>

		<button type="submit" name="submit"  value="search">Search</button>



</form>

			
			


</body>
</html>