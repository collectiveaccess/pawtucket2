<?php
	AssetLoadManager::register("carousel");
?>
	<div class="col1">
		<h1>Libros</h1>
		<article id="infoLibro" class="alignLeft">
			<div class="carrusel">
				<div class="mascara">
					<ul class="articulos">
						<li><img src="fichas/libro1.jpg" alt="mapamundi" /></li>
						<li><img src="fichas/libro1.jpg" alt="mapamundi" /></li>
					</ul>
					<p class="piefoto">Reproducción libro Ptolomeo</p>
				</div>
				<a href="libros.php#" class="items btnminLeft botonIzq">left</a>
				<a href="libros.php#" class="items btnminRight botonDer">right</a>
				<div id="marcador">
					<a href="libros.php#">foto1</a>
					<a href="libros.php#">foto2</a>
					<a href="libros.php#">foto3</a>
					<a href="libros.php#">foto4</a>
					<a href="libros.php#">foto5</a>
					<a href="libros.php#">foto6</a>
				</div>
			</div>
			<header>
				<h2 class="verdeclaro">Biblioteca Dr. Camino</h2>
				<h3>La Biblioteca <?php print caNavLink($this->request, "Dr. Camino", "verdeclaro", "", "Libros", "dr_camino"); ?>, integrada por más de 14.500 libros y documentos de Historia Donostiarra y Guipuzcoana, es uno de los frutos más relevantes del prestigioso <span class="verdeclaro">Instituto Dr. Camino de Historia Donostiarra.</span></h3>
			</header>
			<p class="mini">Constituida por fondos tan importantes como el de <span class="verdeclaro">Serapio Múgica</span>, la Biblioteca recoge importantes producciones editoriales que, con vocación documental y de aportación rigurosa al estudio de los anales sobre la ciudad, contribuyen al conocimiento de su personalidad histórica y cultural.</p>
			<figure class="alignLeft"><?php print caGetThemeGraphic($this->request, "libro1_MIN.jpg", array("alt" => "vista de la biblioteca")); ?><p>Vista del interior de la biblioteca</p></figure>
			<p class="mini">Su emblemática sede de la <span class="verdeclaro">calle 31 de Agosto</span>, es un espacio abierto a instituciones y colectivos culturales donostiarras y guipuzcoanos contando con una biblioteca dotada de enciclopedias con ediciones apreciadas respecto al País Vasco en general y especializada en libros que tratan sobre todo, de la historia donostiarra del XIX y guipuzcoana del siglo XX, a disposición de los investigadores y del público en general.</p>
			<p class="mini">Cuenta asimismo con ejemplares de difícil localización, como catálogos e inventarios, muy útiles para el investigador, conformando un valioso instrumental para el estudio de las diferentes etapas y cuestiones diversas de la historia guipuzcoana y vasca (algunos de estos ejemplares, podían constituir material de “Fuentes para la historia”).</p>
		</article>
		<section class="alignRight aireBottom">
			<article class="ficha">
				<h3 class="verdeclaro">Instituto Dr. Camino de Historia Donostiarra</h3>
				<p>El origen del mismo está en el Grupo Dr. Camino de Historia Donostiarra, cuyo nacimiento oficial se produjo en San Sebastián el día 11 de Enero de 1966, y que fue previamente aprobado, el día 2 de Enero de 1964 por la Junta Directiva de la Comisión Guipuzcoana de la Real Sociedad Bascongada de los Amigos del País (R.S.B.A.P.)</p>
				<?php print caGetThemeGraphic($this->request, "libro1_REL.jpg", array("alt" => "historia donostiarra")); ?>
				<a href="libros.php#" class="btnGris2">Ampliar información</a>
			</article>
			<article class="ficha">
				<h3 class="verdeclaro">Serapio Múgica</h3>
				<p><?php print caGetThemeGraphic($this->request, "autor1.jpg", array("class" => "alignLeft aireRight", "alt" => "autor1")); ?>Su obra como historiador se apoyó en dos pilares: su gran erudición y los abundantes materiales encontrados en el desarrollo de su labor archivística.</p>
				<a href="libros.php#" class="btnGris2">Ampliar información</a>
			</article>
			<article class="ficha">
				<h3 class="verdeclaro">José Ignacio Tellechea</h3>
				<p><?php print caGetThemeGraphic($this->request, "autor2.jpg", array("class" => "alignLeft aireRight", "alt" => "autor2")); ?>Su intensa vida como historiador e investigador se ha ido enriqueciendo con diversas distinciones, siendo miembro numerario de la Real Sociedad Bascongada de los Amigos del País.</p>
				<a href="libros.php#" class="btnGris2">Ampliar información</a>
			</article>
		</section>
	</div>