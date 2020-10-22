<?php
$ip = $_SERVER["REMOTE_ADDR"];

?>
<!DOCTYPE html>
<html lang="en">

<?php include("header.php"); ?>

<body class="nav-md" onload="loadFoto();">
	<style>
		body {
			font-family: Verdana, sans-serif;
			margin: 0;
		}

		* {
			box-sizing: border-box;
		}

		.row>.column {
			padding: 0 8px;
		}

		.row:after {
			content: "";
			display: table;
			clear: both;
		}

		.column {
			float: left;
			width: 25%;
		}

		/* The Modal (background) */
		.modal {
			display: none;
			position: fixed;
			z-index: 1;
			padding-top: 100px;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: #00000069;
		}

		/* Modal Content */
		.modal-content {
			position: relative;
			background-color: #fefefe;
			margin: auto;
			padding: 0;
			width: 90%;
			max-width: 800px;
		}

		/* The Close Button */
		.close {
			color: white;
			position: absolute;
			top: 10px;
			right: 25px;
			font-size: 35px;
			font-weight: bold;
		}

		.close:hover,
		.close:focus {
			color: #999;
			text-decoration: none;
			cursor: pointer;
		}

		.mySlides {
			display: none;
		}

		.cursor {
			cursor: pointer;
		}

		/* Next & previous buttons */
		.prev,
		.next {
			cursor: pointer;
			position: absolute;
			top: 50%;
			width: auto;
			padding: 16px;
			margin-top: -50px;
			color: white;
			font-weight: bold;
			font-size: 20px;
			transition: 0.6s ease;
			border-radius: 0 3px 3px 0;
			user-select: none;
			-webkit-user-select: none;
		}

		/* Position the "next button" to the right */
		.next {
			right: 0;
			border-radius: 3px 0 0 3px;
		}

		/* On hover, add a black background color with a little bit see-through */
		.prev:hover,
		.next:hover {
			background-color: rgba(0, 0, 0, 0.8);
		}

		/* Number text (1/3 etc) */
		.numbertext {
			color: #f2f2f2;
			font-size: 12px;
			padding: 8px 12px;
			position: absolute;
			top: 0;
		}

		img {
			margin-bottom: -4px;
		}

		.caption-container {
			text-align: center;
			background-color: black;
			padding: 2px 16px;
			color: white;
		}

		.demo {
			opacity: 0.6;
		}

		.active,
		.demo:hover {
			opacity: 1;
		}

		img.hover-shadow {
			transition: 0.3s;
		}

		.hover-shadow:hover {
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}

		.img01 {
			width: 100%;
			height: 500px;
			border: 5px;
			border-style: ridge;
		}

		.demo {
			width: 100%;
		}
	</style>

	<!-- page content -->
	<div class="right_col" role="main">
		<div class="row">
			<div class="title_left">
				<h2><a href="index.php">Inicial</a> / Amostras</h2>
			</div>
		</div>
		<br>

		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Amostras</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">
						<div class="item form-group">
							<div class="row">
								<div class="x_content" name="listaFotos" id="listaFotos"></div>
							</div>
						</div>

						<div id="myModal" class="modal">
							<span class="close cursor" onclick="closeModal()">&times;</span>
							<div class="modal-content" style="margin-top: -50px;">
								<?php
								$con = mysqli_connect("localhost", "root", "", "testes");
								$sql = mysqli_query($con, "select id, image from testes.snapshot where usuario = '" . $ip . "' and date(data)  - interval 1 day") or die("erro no select lista de fotos slides");
								$rows = mysqli_num_rows($sql);
								$id = 0;
								while ($result = mysqli_fetch_array($sql)) {
									$id = $id + 1;
									echo "<div class='mySlides'>";
									echo "<div class='numbertext'>{$id} / {$rows}</div>";
									echo "<img src='" . $result['image'] . "' style='width:100%; height: 560px;' />";
									echo "</div>";
								}
								?>

								<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
								<a class="next" onclick="plusSlides(1)">&#10095;</a>

							</div>
						</div>
					</div>
					<br>
					<!-- <div class="item form-group"> -->

					<script src="js/jquery.min.js"></script>
					<script src="js/jquery.Jcrop.js"></script>
					<script type="text/javascript">
						jQuery(function($) {

							var jcrop_api;

							$('#target').Jcrop({
								onChange: showCoords,
								onSelect: showCoords,
								onRelease: clearCoords
							}, function() {
								jcrop_api = this;
							});

							$('#coords').on('change', 'input', function(e) {
								var x1 = $('#x1').val(),
									x2 = $('#x2').val(),
									y1 = $('#y1').val(),
									y2 = $('#y2').val();
								jcrop_api.setSelect([x1, y1, x2, y2]);
							});

						});

						// Simple event handler, called from onChange and onSelect
						// event handlers, as per the Jcrop invocation above
						function showCoords(c) {
							$('#x1').val(c.x);
							$('#y1').val(c.y);
							$('#x2').val(c.x2);
							$('#y2').val(c.y2);
							$('#w').val(c.w);
							$('#h').val(c.h);
						};

						function clearCoords() {
							$('#coords input:text').val('');
						};
					</script>

					<link rel="stylesheet" href="css/main.css" type="text/css" />
					<!--<link rel="stylesheet" href="css/demos.css" type="text/css" />-->
					<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />



					<div class="row">
						<div class="jc-demo-box" style="margin-left: 252px;">


							<!-- This is the image we're attaching Jcrop to -->

							<img src="images/pool.jpg" id="target" alt="[Jcrop Example]" />


							<!-- This is the form that our event handler fills -->
							<form id="coords">

								<div class="inline-labels">
									<label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
									<label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
									<label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
									<label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
									<label>W <input type="text" size="4" id="w" name="w" /></label>
									<label>H <input type="text" size="4" id="h" name="h" /></label>
								</div>

								<div class="col-md-8" style="text-align: right;">
									<input class="btn btn-success" type="submit" value="Cortar" />
								</div>
							</form>

						</div>
					</div>

					<!-- </div> -->



				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- /page content -->

	<?php include("footer.php"); ?>
	<script>
		//Identificação do usuário
		var ip = '<?php echo $ip; ?>';

		function openModal() {
			document.getElementById("myModal").style.display = "block";
		}

		function closeModal() {
			document.getElementById("myModal").style.display = "none";
		}

		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
			showSlides(slideIndex += n);
		}

		function currentSlide(n) {
			showSlides(slideIndex = n);
		}

		function showSlides(n) {
			var i;
			var slides = document.getElementsByClassName("mySlides");
			var dots = document.getElementsByClassName("demo");
			var captionText = document.getElementById("caption");
			if (n > slides.length) {
				slideIndex = 1
			}
			if (n < 1) {
				slideIndex = slides.length
			}
			for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none";
			}
			for (i = 0; i < dots.length; i++) {
				dots[i].className = dots[i].className.replace(" active", "");
			}
			slides[slideIndex - 1].style.display = "block";
			dots[slideIndex - 1].className += " active";
			captionText.innerHTML = dots[slideIndex - 1].alt;
		}
	</script>
	<script>
		coords.onsubmit = async (e) => {
			e.preventDefault();

			const form = document.getElementById('coords');
			let data = new FormData();
			data.append('x1', form.x1.value);
			data.append('y1', form.y1.value);
			data.append('x2', form.x2.value);
			data.append('y2', form.y2.value);
			data.append('w', form.w.value);
			data.append('h', form.h.value);

			alert('x1: ' + form.x1.value + '\ny1: ' + form.y1.value + '\nx2: ' + form.x2.value + '\ny2: ' + form.y2.value + '\nw: ' + form.w.value + '\nh: ' + form.h.value);

			fetch('upload.php', {
				method: 'POST',
				//headers: {'Content-Type':'application/x-www-form-urlencode'},
				body: data
			}).then(function(response) {
				response.text()
					.then(function(result) {
						alert(result);
					});
			});

		};

		//Carrega as fotos ao atualizar
		function loadFoto() {
			//pantalla = document.getElementById("screen");

			fetch('salvarFoto.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: 'action=load&ip=' + ip
			}).then(function(response) {
				response.text()
					.then(function(result) {

						var foto = result.split(';');
						var qtd = result.match(/;/gi).length;

						for (var i = 0; i < qtd; i++) {
							var nums = i + 1;
							//Div principal
							var fotos = document.getElementById('listaFotos');

							//Div de coluna
							var col = document.createElement('div');
							col.setAttribute('class', 'col-md-55');
							fotos.appendChild(col);

							//Div de thumbnail
							var thumb = document.createElement('div');
							thumb.setAttribute('class', 'thumbnail');
							col.appendChild(thumb);

							//Div de View
							var view = document.createElement('div');
							view.setAttribute('class', 'image view view-first');
							thumb.appendChild(view);

							//Imagens vindas do banco
							var img = document.createElement("img");
							img.setAttribute("src", foto[i]);
							img.setAttribute("width", "100%");
							img.setAttribute("alt", ip);
							img.setAttribute("id", "foto_" + i);
							img.setAttribute("name", "foto_" + i);
							img.setAttribute("class", "foto_" + i);
							img.setAttribute("onclick", "openModal();currentSlide(" + nums + ")");
							img.setAttribute("style", "border-style: solid; border-color: yellow; cursor: pointer;");
							view.appendChild(img);

							//div de Mascara
							var mask = document.createElement('div');
							mask.setAttribute('class', 'mask');
							view.appendChild(mask);



							//Div de titulo
							var caption = document.createElement('div');
							caption.setAttribute('class', 'caption');
							thumb.appendChild(caption);

							//Texto no titulo
							var title = document.createElement('p');
							var text = document.createTextNode('Clique para aumentar a imagem');
							title.appendChild(text);
							caption.appendChild(title);
						}
					});
			});
		}
	</script>
</body>

</html>