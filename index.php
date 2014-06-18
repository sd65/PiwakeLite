<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Piwake Lite</title>
	<link rel="icon" type="image/png" href="img/favicon.png" />
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>

<body class="container-fluid">

	<div class="row">

		<div class="col-xs-10 col-xs-offset-1">

			<h1>Piwake <small>Lite</small></h1>

			<div class="menu panel panel-default">
				<div class="panel-body">

					<div class="col-md-6">
						<ul class="filiere nav nav-tabs">
							<!-- Change your Filiere code here ! -->
							<li><a href="#">MMI_S1</a></li>
							<li><a href="#">MMI_S2</a></li>
							<li><a href="#">MMI_S3</a></li>
							<li><a href="#">MMI_S4</a></li>
						</ul>
					</div>

					<div class="col-md-6">
						<ul class="year nav nav-tabs">
							<!-- Change years code here ! -->
							<li><a href="#">2013</a></li>
							<li><a href="#">2014</a></li>
							<li><a href="#">2015</a></li>
						</ul>
					</div>

					<div class="col-md-3">
						<div class="btn-toolbar" role="toolbar">
					      <div class="btn-group">
					        <button type="button" data-action="prev" class="btn btn-default">&laquo;</button>
					        <button type="button" data-action="now" class="btn btn-default">Maintenant</button>
					        <button type="button" data-action="next" class="btn btn-default">&raquo;</button>
						    </div>
						</div>
					</div>

					<div class="col-md-9 week">
						<select class="form-control">
							<?php
								for($i=1; $i <= 52; $i++)
								{
									echo "<option value='$i'>Semaine $i</option>";
								}
							?>
						</select>
					</div>
				</div>
			</div>

			<div style="overflow:auto">
				<table class="table" id="table" style="display:none;">

					<thead>
						<tr>
							<th class="hourTitle">Heures</th>
							<?php
								for($i=8; $i <= 19; $i++)
								{
									echo "<th class='hour'>$i</th>";
									echo "<th class='halfHour'>30</th>";
								}
							?>
						</tr>
					</thead>

					<tbody>
						<!-- And here will be output calendar ! -->
					</tbody>

				</table>
			</div>

			<!-- This will be remove when loading finished -->
			<div id="loader">
				<img src="img/loader.gif" alt="Chargement...">
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
					Réalisé par Sylvain Doignon
					<span class="pull-right">2014 | <a href=""><span class="glyphicon glyphicon-send"></span> &#160;See on Github</a></span>
				</div>
			</div>

		</div>
	</div>

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.cookie.min.js"></script>
	<script src="js/script.js"></script>

</body>

</html>
