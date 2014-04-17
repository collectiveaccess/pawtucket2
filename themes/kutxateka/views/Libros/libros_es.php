<?php
	AssetLoadManager::register("carousel");
?>
	<div class="col1">
		<h1>Libros</h1>
		<article id="infoLibro" class="alignLeft">
			<div class="carrusel jcarousel-wrapper">
				<div class="mascara jcarousel">
					<ul class="articulos">
						<li class="slide"><?php print caGetThemeGraphic($this->request, "books/2Door.jpg", array("alt" => "Puerta de acceso a la Biblioteca Dr. Camino")); ?><p class="piefoto"><i>Puerta de acceso a la Biblioteca Dr. Camino</i>, <u>Mikel Astigarraga</u> 2011, Kutxateka</p></li>
						<li class="slide" style="padding-top:59px;"><?php print caGetThemeGraphic($this->request, "books/1map.jpg", array("alt" => "Facsímil de Ptolomeo")); ?><p class="piefoto"><i>Facsímil de Ptolomeo</i>, <u>Juantxo Egaña</u>, Kutxateka</p></li>
						<li class="slide"><?php print caGetThemeGraphic($this->request, "books/3Library.jpg", array("alt" => "Sala de lectura")); ?><p class="piefoto"><i>Sala de lectura</i>, <u>Mikel Astigarraga</u>, 2011, Kutxateka</p></li>
						<li class="slide"><?php print caGetThemeGraphic($this->request, "books/4Stacks.jpg", array("alt" => "Compactos con libros")); ?><p class="piefoto"><i>Compactos con libros</i>, <u>Mikel Astigarraga</u>, 2011, Kutxateka</p></li>
					</ul>
				</div>
				<a href="#" class="btnminLeft items" id="detailScrollButtonPrevious">left</a><a href="#" class="btnminRight items" id="detailScrollButtonNext">right</a>
				<p class="jcarousel-pagination"></p>
			</div>
			 <script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.jcarousel')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPrevious')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '-=1'
						});
			
					/*
					 Next control initialization
					 */
					$('#detailScrollButtonNext')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '+=1'
						});
						
					$('.jcarousel-pagination')
					.on('jcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('jcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination();

						
				});
			</script>
			
			
			
			
			
			
			<header>
				<h2 class="verdeclaro">Biblioteca Dr. Camino</h2>
				<h3>La Biblioteca <?php print caNavLink($this->request, "Dr. Camino", "verdeclaro", "", "Libros", "bio_camino_es"); ?>, integrada por más de 14.500 libros y documentos de Historia Donostiarra y Guipuzcoana, es uno de los frutos más relevantes del prestigioso <?php print caNavLink($this->request, "Instituto Dr. Camino de Historia Donostiarra", "verdeclaro", "", "Libros", "dr_camino_inst_es"); ?>.</h3>
			</header>
			<p class="mini">Constituida por fondos tan importantes como el de <?php print caNavLink($this->request, "Serapio Múgica", "verdeclaro", "", "Libros", "bio_mugica_es"); ?>, la Biblioteca recoge importantes producciones editoriales que, con vocación documental y de aportación rigurosa al estudio de los anales sobre la ciudad, contribuyen al conocimiento de su personalidad histórica y cultural.</p>
			<figure class="alignLeft"><?php print caGetThemeGraphic($this->request, "libro1_MIN.jpg", array("alt" => "vista de la biblioteca")); ?><p><i>Vista del interior de la biblioteca</i></p></figure>
			<p class="mini">Su emblemática sede de la <?php print caNavLink($this->request, "calle 31 de Agosto", "verdeclaro", "", "Libros", "31_de_agosto_es"); ?>, es un espacio abierto a instituciones y colectivos culturales donostiarras y guipuzcoanos contando con una biblioteca dotada de enciclopedias con ediciones apreciadas respecto al País Vasco en general y especializada en libros que tratan sobre todo, de la historia donostiarra del XIX y guipuzcoana del siglo XX, a disposición de los investigadores y del público en general.</p>
			<p class="mini">Cuenta asimismo con ejemplares de difícil localización, como catálogos e inventarios, muy útiles para el investigador, conformando un valioso instrumental para el estudio de las diferentes etapas y cuestiones diversas de la historia guipuzcoana y vasca (algunos de estos ejemplares, podían constituir material de “Fuentes para la historia”).</p>
		</article>
		<section class="alignRight aireBottom">
			<article class="ficha">
				<h3 class="verdeclaro">Instituto Dr. Camino de Historia Donostiarra</h3>
				<p>El origen del mismo está en el Grupo Dr. Camino de Historia Donostiarra, cuyo nacimiento oficial se produjo en San Sebastián el día 11 de Enero de 1966, y que fue previamente aprobado, el día 2 de Enero de 1964 por la Junta Directiva de la Comisión Guipuzcoana de la Real Sociedad Bascongada de los Amigos del País (R.S.B.A.P.)</p>
				<?php print caGetThemeGraphic($this->request, "libro1_REL.jpg", array("alt" => "historia donostiarra")); ?>
				<?php print caNavLink($this->request, "Ampliar información", "btnGris2", "", "Libros", "dr_camino_inst_es"); ?>
			</article>
			<article class="ficha">
				<h3 class="verdeclaro">Serapio Múgica</h3>
				<p><?php print caGetThemeGraphic($this->request, "autor1.jpg", array("class" => "alignLeft aireRight", "alt" => "autor1")); ?>Su obra como historiador se apoyó en dos pilares: su gran erudición y los abundantes materiales encontrados en el desarrollo de su labor archivística.</p>
				<?php print caNavLink($this->request, "Ampliar información", "btnGris2", "", "Libros", "bio_mugica_es"); ?>
			</article>
			<article class="ficha">
				<h3 class="verdeclaro">José Ignacio Tellechea</h3>
				<p><?php print caGetThemeGraphic($this->request, "autor2.jpg", array("class" => "alignLeft aireRight", "alt" => "autor2")); ?>Su intensa vida como historiador e investigador se ha ido enriqueciendo con diversas distinciones, siendo miembro numerario de la Real Sociedad Bascongada de los Amigos del País.</p>
				<?php print caNavLink($this->request, "Ampliar información", "btnGris2", "", "Libros", "bio_tellechea_es"); ?>
			</article>
		</section>
	</div>