<div class="page_title">
    <h1>Printers’ addresses</h1>
    <div class="ornament">
<?php
        $ornaments = array(
            'head_ornament-10.svg',
            'head_ornament-11.svg',
            'head_ornament-12.svg',
        );
        $rand_ornament = array_rand($ornaments, 1);
		print caGetThemeGraphic($this->request, $ornaments[$rand_ornament], array("class" => "page_title_ornament", "alt" => "Header Ornament"));
?>
    </div>
</div>

<div class="text_content">
<?php
	if($vs_intro = $this->getVar("paratext_printers_intro")){
		print "<p>".$vs_intro."</p>";
?>
		<p style="clear:both"></p>
<?php
	}
?>
    <table id="sortable_table">

        <thead>
            <tr>
                <th onclick="sortTable(0)">Printer's name</th>
                <th onclick="sortTable(1)">Address</th>
                <th onclick="sortTable(2)">City</th>
            </tr>
        </thead>

        <tbody>
            <tr><td data-label='Printers name'>Imprenta de Don Isidro Lopez</td><td data-label='Address'>calle de los Libreros</td><td data-label=City>Alcalá</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Pedro Escudèr</td><td data-label='Address'>en la calle Condál</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Oficina de Pablo Nadal</td><td data-label='Address'>calle del Torrente de Junqueras </td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Francisco Suriá</td><td data-label='Address'>Vendese en su Casa, calle de la Paja y en la de Carlos Sapera, calle de la Libreria</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Carlos Sapera</td><td data-label='Address'>Vendese en su Casa, calle de la Librería </td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Oficina de Pablo Campins</td><td data-label='Address'>calle de Amargós. Vendese en su misma casa, y en la de el Teatro</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Carlos Gibert y Tutó</td><td data-label='Address'>en la Libretería,</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Juan Francisco Piferrer</td><td data-label='Address'>Plaza del Angel núm. 4</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Oficina de Francisco Genéras</td><td data-label='Address'>bajada de la Carcel</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Joseph Llopis</td><td data-label='Address'>à la plaça del Angel. Vendense en casa Iuan Piferrer à la mesma plaça</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Hereus de la Viuda Pla</td><td data-label='Address'>carrer dels Cotoners</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Herederos de la Viuda Plan</td><td data-label='Address'>calle de los Algodoneros</td><td data-label=City>Barcelona</td></tr>
            <tr><td data-label='Printers name'>Oficina de la viuda de Comes</td><td data-label='Address'></td><td data-label=City>Cádiz</td></tr>
            <tr><td data-label='Printers name'>Oficina de Francisco Periu</td><td data-label='Address'></td><td data-label=City>Isla de León</td></tr>
            <tr><td data-label='Printers name'>Andres Ramirez</td><td data-label='Address'>Calle de los tres peces</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Antonio Sanz</td><td data-label='Address'>Plazuela de la calle de la Paz</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Libreria de los Herederos de Gabriel de Leon</td><td data-label='Address'>La Puerta del Sol</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Teresa de Guzmán</td><td data-label='Address'>Hallaràse en su Lonja de Comedias de la Puerta del Sol</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Librería de Quiroga </td><td data-label='Address'>calle de la Concepcion  Gerónima, junto à Barrio Nuevo</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Oficina del Diario</td><td data-label='Address'>en el puesto de Joseph Sanchez, calle del Príncipe, frente al Coliseo</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Joseph Gonzalez</td><td data-label='Address'>vive en la calle del Arenal</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Libreria de Juan Pablo Gonzalez</td><td data-label='Address'>calle de Atocha, Casa nueva de Sto. Thomas : y en el puesto de Josef Cano, calle de Toledo, frente del Hospital de la Latina</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Librería de Gonzalez</td><td data-label='Address'>calle de Atocha frente los Cinco Gremios</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Libreria de Cerro</td><td data-label='Address'>calle de Cedaceros, y en su puesto, calle de Alcalá</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Librería de Castillo</td><td data-label='Address'>frente á las gradas de San Felipe el Real : en la de Sancha, calle del Lobo : y en el puesto de Sanchez, calle del Príncipe</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>en el Despacho principal de Diario, Carrera de San Gerónimo, frente de la Librería de Maféo, junto la de Copin; y en los Puestos de la Puerta del Sol, y frente de Santo Tomás, á dos reales</td><td data-label='Address'></td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Librería de Don Isidro Lopez</td><td data-label='Address'>calle de la Cruz Numero 3, frente de la Nevería</td><td data-label=City>Madrid</td></tr>
            <tr><td data-label='Printers name'>Imprenta, y Librerìa de Manuel Fernandez</td><td data-label='Address'>Caba Baxa, frente de la casa de Don Vicente Quadros</td><td data-label=City>Madrid</td></tr>
        	 <tr><td data-label='Printers name'>Oficina de don Antonio Fernandez de Quincozes</td><td data-label='Address'></td><td data-label=City>Málaga</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Casas y Vidondo</td><td data-label='Address'></td><td data-label=City>Málaga</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Miguel Domingo</td><td data-label='Address'></td><td data-label=City>Palma</td></tr>
            <tr><td data-label='Printers name'>Imprenta Papelería de José Mir</td><td data-label='Address'>Cadena, II</td><td data-label=City>Palma</td></tr>
            <tr><td data-label='Printers name'>Palma, tienda de Antonio Borrás </td><td data-label='Address'>Casita de madera. Cuesta del Teatro. También se escríben Cartas</td><td data-label=City>Palma</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Francisco Garcia Onorato y San Miguel</td><td data-label='Address'>Vive en la calle de Libreros, junto à la Universidad</td><td data-label=City>Salamanca</td></tr>
            <tr><td data-label='Printers name'>Imprenta de D. Francisco de Tóxar</td><td data-label='Address'>calle de la Rua</td><td data-label=City>Salamanca</td></tr>
            <tr><td data-label='Printers name'>Imprenta de la Santa Cruz</td><td data-label='Address'>calle de la Rua</td><td data-label=City>Salamanca</td></tr>
            <tr><td data-label='Printers name'>Librería de la Viuda é Hijo de Quiroga</td><td data-label='Address'>calle de las Carretas número 9</td><td data-label=City>Salamanca</td></tr>
            <tr><td data-label='Printers name'>Viuda de Francisco de Leefdael</td><td data-label='Address'>Casa de el Correo Viejo</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Imprenta del Correo Viejo</td><td data-label='Address'>junto al Buen-Sucesso</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Thomê de Dios Miranda</td><td data-label='Address'>a costa de Pedro de Segura, Mercader de Libros: vendese en su casa en calle de Genova</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Francisco de Leefdael</td><td data-label='Address'>junto à la Casa Professa de la Compañia de Jesus</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Francisco de Leefdael</td><td data-label='Address'>Casa de Correo Viejo</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Imprenta Real</td><td data-label='Address'>Casa del Correo Viejo</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Joseph Padrino, Mercader de Libros</td><td data-label='Address'>calle de Genova</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Imprenta Castellana, y Latina de los Herederos de Tomàs Lopez de Haro</td><td data-label='Address'>calle de Genova</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Imprenta Castellana, y Latina de Joseph Antonio de Hermosilla</td><td data-label='Address'>calle de Genova</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Manuèl Nicolàs Vazquez</td><td data-label='Address'>calle de Genova</td><td data-label=City>Sevilla</td></tr>
            <tr><td data-label='Printers name'>Oficina del Diario</td><td data-label='Address'>calle del Mar, frente la de la Cruz Nueva, casa baxa, núm. 5</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Imprenta y Librería de Miguel Domingo</td><td data-label='Address'>calle de Caballeros número 48</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Domingo y Mompié</td><td data-label='Address'>hallará en su librería, calle de Caballeros, núm. 48</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Estevan</td><td data-label='Address'>frente el horno de Salicofres</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Joseph, y Thomàs de Orga</td><td data-label='Address'>calle de la Cruz Nueva, junto al Real Colegio de Corpus Christi</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Viuda de Joseph de Orga</td><td data-label='Address'>calle de la Cruz Nueva, junto [al] Real Colegio del Señor Patriarca</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>lldefonso Mompié</td><td data-label='Address'>calle nueva de San Fernando, núm. 63 y 64, junto al mercado</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Imprenta de José Gimeno</td><td data-label='Address'>Véndese en su librería, frente al Miguelete, </td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Librería de José Cárlos Navarro</td><td data-label='Address'>calle de la Lonja de la Seda</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Imprenta de D. Benito Monfort</td><td data-label='Address'></td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Francisco Mestre</td><td data-label='Address'>junto al Molino de Rovella. Vendese en casa Iusepe Rodrigo, enfrente de la Fuente del Mercado</td><td data-label=City>Valencia</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Alonso del Riego</td><td data-label='Address'>frente de la Universidad</td><td data-label=City>Valladolid</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Santaren</td><td data-label='Address'></td><td data-label=City>Valladolid</td></tr>
            <tr><td data-label='Printers name'>Herederos de D. Dormer</td><td data-label='Address'></td><td data-label=City>Zaragoça</td></tr>
            <tr><td data-label='Printers name'>Imprenta de Roque Gallifa </td><td data-label='Address'></td><td data-label=City>Zaragoza</td></tr>
            <tr><td data-label='Printers name'>Imprenta que està en la Plaza del Carbon sobre el Peso Real</td><td data-label='Address'></td><td data-label=City>Zaragoza</td></tr>
			<tr><td data-label='Printers name'>Viuda de Alonso Martín</td><td data-label='Address'>vendese en su casa al lado del correo mayor</td><td data-label=City>Madrid</td></tr>
			<tr><td data-label='Printers name'>Imprenta de Francisco Garcia Onorato y San Miguèl, Impressor</td><td data-label='Address'>Vive en la calle de Libreros, junto à la Vniversidad</td><td data-label=City>Salamanca</td></tr>
        </tbody>

    </table>

    <script>
    
    </script>

</div>