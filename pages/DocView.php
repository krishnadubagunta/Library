<!DOCTYPE html>
<html>
<head>
	<title>Document Search</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
	<table class="table" style="width:800px; margin-left: calc(50% - 400px); padding: 20px; border-radius: 12px; margin-top: 20px; border: 1px solid black;">
	  <thead class="thead-inverse" style="background: #8ab8df">
	    <tr>
	      <th>Doc ID</th>
	      <th>Title</th>
	      <th>Branch Name</th>
	      <th>Branch Location</th>
	      <th>Status</th>
	      <th>Actions</th>
	    </tr>
	  </thead>
	  <tbody id="DocumentsTable">
	  </tbody>
	</table>

	<footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script type="text/javascript" src="../js/App.js"></script>
		<script type="text/javascript">App.DocumentViewByBranch.init();</script>
		<style type="text/css">

		</style>

	</footer>
</body>
</html>