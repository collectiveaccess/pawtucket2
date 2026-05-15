<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name='description' content='' lang='Fr'>
	<meta name="author" content="Marc Pedneault pour La Boîte Rouge VIF">
	
<!-- Mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
<!-- Police d'écriture -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
	
<!-- Styles -->
	<style>
	/* Lato (Google Fonts) */
		.lato-thin
		{
			font-family: "Lato", sans-serif;
			font-weight: 100;
			font-style: normal;
		}

		.lato-light {
		  font-family: "Lato", sans-serif;
		  font-weight: 300;
		  font-style: normal;
		}

		.lato-regular {
		  font-family: "Lato", sans-serif;
		  font-weight: 400;
		  font-style: normal;
		}

		.lato-bold {
		  font-family: "Lato", sans-serif;
		  font-weight: 700;
		  font-style: normal;
		}

		.lato-black {
		  font-family: "Lato", sans-serif;
		  font-weight: 900;
		  font-style: normal;
		}

		.lato-thin-italic {
		  font-family: "Lato", sans-serif;
		  font-weight: 100;
		  font-style: italic;
		}

		.lato-light-italic {
		  font-family: "Lato", sans-serif;
		  font-weight: 300;
		  font-style: italic;
		}

		.lato-regular-italic {
		  font-family: "Lato", sans-serif;
		  font-weight: 400;
		  font-style: italic;
		}

		.lato-bold-italic {
		  font-family: "Lato", sans-serif;
		  font-weight: 700;
		  font-style: italic;
		}

		.lato-black-italic {
		  font-family: "Lato", sans-serif;
		  font-weight: 900;
		  font-style: italic;
		}
	/* FIN Lato (Google Fonts) */

		::selection
			{
				background:rgba(0, 0, 255, 0.3);
			}
			
		body
			{
				font-family:'Open Sans', Helvetica, Arial, sans-serif;
				color:#292723;
				
				width:calc(100% - 2em);
				margin:1em;
			}

		header
			{
				text-align:center;
			}

		header .logos
			{
				margin:1em;
				max-height:150px;
				max-width:300px;
				vertical-align:middle;
			}
			
		/* Pop-up */
		#popUp
			{
				transition-duration:0.25s;
				
				width:98%;
				height:98%;
				background-color:rgb(15, 15, 15);
				outline:1px solid #ccc;
				border-radius:0.25em;
				padding:2em;
				box-shadow:0 0 25px 10px rgba(0, 0, 0, 0.75);
				
				position:fixed;
				left:0;
				top:0;
				right:0;
				bottom:0;
				margin:auto;
				
				display:none;
				z-index:1000;
			}
			
		#popUp #titresVideos
			{
				color:white;
				font-size:1em;
				text-transform:uppercase;
			}
			
		#popUp iframe
			{
				width:100%;
				height:inherit;
			}
			
		.contenuAffiche
			{
				display:block !important;
			}
			
		#popUp button
			{
				position:absolute;
				z-index:2;
				right:2em;
				aspect-ratio:1;
				width:2em;
				
				background-color:#EFEFEF;
				color:#666666;
				border:none;
			}
		/* FIN pop-up */
			
		#contenu
			{
				max-width:1000px;
				width:100%;
				margin:auto;
			}

		#contenu h1, #contenu h2
			{
				font-family:"lato";
				font-weight:normal;
				font-style:normal;
				
				text-transform:uppercase;
				color:#D71821;
				line-height:1.1em;
			}
			
		#contenu h1
			{
				font-size:20px;
			}

		#contenu h1 .noir
			{
				color:#292723;
			}
			
		#contenu h2
			{
				font-size:18px;
			}
			
		#contenu h3
			{
				font-size:16px;
			}

		#contenu p, #contenu table
			{
				line-height:1.8em;
				font-size:14px;
			}

		.light
			{
				font-weight:300;
			}
			
		.italique
			{
				font-style:italic;
			}

		.plusPetit
			{
				font-size:0.75em !important;
				line-height:1.4em !important;
			}
			
		#contenu h1 .light
			{
				display:block;
			}
			
		#contenu .videoLarge
			{
				width:100%;
				aspect-ratio:16/9;
				/*margin:0 1em 0.5em 0;
				float:left;*/
			}
			
		.videoCliquable, #popUp button
			{
				cursor:pointer;
			}
			
		.videoCliquable
			{
				position:relative;
				background-size:cover;
				background-position:center;
			}
			
		.videoCliquable:after
			{
				content:"";
				background-image:url("https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/btnJouer.png");
				background-size:contain;
				
				display:block;
				width:15%;
				aspect-ratio:1;
				
				opacity:0.5;
				
				position:absolute;
				top:0;
				left:0;
				right:0;
				bottom:0;
				margin:auto;
				transition-duration:0.1s;
			}
			
		.videoCliquable:hover:after
			{
				opacity:0.75;
			}

		.colonnesVariables
			{
				display:grid;
				gap:1em;
				
				position:relative;
			}
			
		.colonnesVariables:has(:not(.jour))
			{
				grid-template-columns:repeat(4, 1fr);
			}
			
		.colonnesVariables.jour
			{
				grid-template-columns:repeat(5, 1fr);
			}
			
		.colonnesVariables.jour
			{
				align-items:end;
			}
			
		.colonnesVariables div
			{
				display:inline-grid; 
			}
			
		.colonnesVariables .videoCliquable
			{
				width:100%;
				aspect-ratio:16/9;
			}
			
		.colonnesVariables .videoCliquable + p
			{
				/*margin-block-start:0;*/
				text-align:center;
				margin-block-start:0.5em;
				margin-block-end:0;
				line-height:1em !important;
			}

		#contenu h2:has(+ .colonnesVariables > div > p + .videoCliquable)
			{
				margin-block:0;
				line-height:1em !important;
			}
			
		.colonnesVariables p:has(+.videoCliquable)
			{
				margin-block-start:0;
				margin-block-end:0.5em;
				line-height:1em !important;
			}
			
		.colonnesVariables.jour
			{
				margin-left:1em;
				margin-bottom:1em;
			}
			
		.colonnesVariables.jour:not:(:first-child)
			{
				margin-block-start:1em;
			}
			
		.jour1:before
			{
				content:"Jour 1";
			}

		.jour2:before
			{
				content:"Jour 2";
			}

		.jour3:before
			{
				content:"Jour 3";
			}
			
		.jour3
			{
				margin-bottom:4em;
			}

		.jour:before
			{
				position:absolute;
				left:-1.25em;
				bottom:0;
				
				width:1em;
				height:calc(100% - 1.5em);
				
				background:#ccc;
				color:white;
				font-weight:bold;
				line-height:1.2em;
				/*text-orientation:upright;*/
				text-align:left;
				writing-mode:sideways-lr;
				text-transform:uppercase;
				
				padding-bottom:0.5em;
			}
			
		.fondGris
			{
				background-color:#e6e6e6;
				padding:1em 0.75em;
				margin-top:2em;
				margin-bottom:1em;
			}
			
		.fondGris h2
			{
				/*margin-left:-0.25em;
				padding-block-start:0.5em;*/
				margin-block-start:0;
				margin-block-end:0;
			}

		.fondGris h3
			{
				/*font-weight:100;
				margin-left:-0.25em;*/
				margin-block-start:0.25em;
				
				font-family:"lato";
				font-weight:normal;
				font-style:normal;
				
				text-transform:uppercase;
			}
			
		.fondGris .citation
			{
				font-size:1.25em;
			}
			
		.fondGris .signature
			{
				font-style:italic;
				font-size:0.75em;
				margin-left:1em;
			}
			
		.fondGris hr
			{
				border:transparent;
				width:100%;
			}
			
		.fondGris .deuxSurTrois
			{
				width:calc(100% / 3 * 2 - 1em);
			}
			
		.fondGris .unSurTrois
			{
				width:calc(100% / 3);
				float:right;
			}
			
		.fondGris .unSurTrois h2
			{
				margin-block-start:0;
				padding-block-start:0;
			}
			
		.fondGris .fauxTitre
			{
				font-weight:bold;
				font-size:1.25em;
				margin-right:0.25em;
			}
			
		.fondGris .petitGrasItalic
			{
				font-style:italic;
				font-weight:bold;
				margin-left:2.75em;
				
				display:block;
			}

		.fondGris .btnTelecharger
			{
				vertical-align:middle;
				height:1em;
				margin-left:0.75em;
			}

		.fondGris .alinea
			{
				margin-left:4em;
				display:block;
			}
			
		.fondGris .demiLigne
			{
				display:block;
				margin:0.4em;
			}
			
		.fondGris table
			{
				margin-left:2.75em;
				
				border-collapse:collapse;
				background-color:#bfbfbf;
				border:5px solid white;
				
				table-layout:fixed;
			}
			
		.fondGris table th, .fondGris table td
			{
				padding:0.4em 0.75em;
			}
			
		.fondGris table th
			{
				border:3px solid white;
				text-align:left;
			}
			
		.fondGris table td
			{
				border:1px solid white;
			}
			
		/*.fondGris + .fondGris
			{
				padding:0.75em 1em;
			}*/
			
		.fondGris .trait:before
			{
				content:"";
				
				height:3px;
				width:1.75em;
				background-color:black;
				
				position:absolute;
				left:-3em;
				top:0.5em;
			}
			
		.fondGris + .fondGris p
			{
				margin-left:1.5em;
			}
			
		.fondGris .trait
			{
				position:relative;
				display:block;
			}
			
		/*.fondGris .trait + b
			{
				font-size:0.75em;
			}*/
			
		footer .logos
			{
				display:block;
				margin:4em auto;
				max-height:150px;
				max-width:300px;
				vertical-align:middle;
			}
			
		@media only screen and (max-width: 1000px) and (orientation: portrait)
			{
				/*body
					{
						font-size:1em;
					}*/
					
				header .logos
					{
						max-height:100px;
					}
					
				#popUp button
					{
						top:0.5em;
						right:0.5em;
						font-size:1.5em;
						width:1.5em;
					}
					
				/*#contenu h1
					{
						font-size:1.75em;
					}
				
				#contenu h2
					{
						font-size:1.25em;
					}*/
					
				#contenu p
					{
						line-height:1.4em;
					}
					
				#contenu .videoLarge
					{
						width:100%;
						aspect-ratio:16/9;
						/*margin:auto;
						float:unset;*/
					}
					
				#expertsInvites, #rencontres
					{
						border-radius:1px;
						outline:1px solid gray;
						outline-offset:4px;
					}
					
				#expertsInvites.ouvert, #rencontres.ouvert
					{
						background-color:#ccc;
						outline:4px solid #ccc;
						outline-offset:unset;
					}
					
				#expertsInvites:after, #rencontres:after
					{
						content:"";
						display:block;
						width:0.75em;
						margin:0.25em;
						aspect-ratio:1;
						float:right;
						
						background-image:url("https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/btnOuvrir.png");
						background-repeat:no-repeat;
						background-size:contain;
						background-position:center;
						
						filter:invert(1) opacity(0.75);
						
						transition-duration:0.25s;
					}
					
				#expertsInvites.ouvert:after, #rencontres.ouvert:after
					{
						transform:rotate3d(180,0,0,180deg);
					}
					
				#expertsInvites + div, #rencontres + div
					{
						display:none;
					}
				
				#expertsInvites, #rencontres
					{
						width:calc(100% - 0.75em - (2 * 0.25em));
						padding-right:calc(0.75em + (2 * 0.25em));
					}
					
				#expertsInvites:after, #rencontres:after
					{
						margin-right:-1em !important;
					}
				
				.colonnesVariables:has(:not(.jour)), .colonnesVariables.jour
					{
						display:grid;
						grid-template-columns:repeat(2, 1fr);
					}
					
				.colonnesVariables .videoCliquable + p
					{
						margin-block-end:0;
					}
					
				.fondGris
					{
						width:100%;
						margin-left:-0.75em;
					}
					
				.fondGris .deuxSurTrois
					{
						width:100%;
						
					}
					
				.fondGris .unSurTrois
					{
						width:100%;
						
					}
					
				.fondGris table
					{
						margin-left:unset;
					}
					
				.fondGris .alinea
					{
						margin-left:1.5em;
					}
					
				.fondGris + .fondGris
					{
						width:100%;
						margin-left:-0.75em;
						padding:1em 0.75em;
					}
			}
	</style>
	
<!-- Favicon
	<link rel="icon" type="image/x-icon" href="favicon.ico"> -->
	<title>L’apprentissage basé sur les objets</title>
</head>
<body>
	<!--<header>
		<img src="https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/LogoUdeM.png" class='logos'>
	</header>-->
	
<!-- Pop-up -->
	<div id="popUp">
		<button onclick="fermerPopUp();">𐌗</button>
		
		<h1 id='titresVideos'></h1>
		<iframe id="iframeVimeo" src="#" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media" title=""></iframe>
		<script src="https://player.vimeo.com/api/player.js"></script>
	</div>

<!-- Contenu de la page -->
	<div id="contenu">
		<h1><span class='light'>Place aux Premiers Peuples</span><span class='noir'>Rencontres au coeur de la collection ethnographique</span></h1>
	
		<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/PremiersPeuples.jpg');" onclick="afficherContenu(1);" class="videoLarge videoCliquable"></div>
		
		<h2>Un projet didactique qui donne une voix aux biens culturels de la collection</h2>
		
		<p>Dans le cadre d’un projet ayant pour objectif de contribuer à la reconnaissance et la valorisation des perspectives, savoirs et savoir-faire des Premiers Peuples à l’UdeM, le professeur en didactique Kevin Péloquin et son équipe proposent d’ajouter une voix aux biens culturels des Premiers Peuples afin de faciliter la mobilisation de contenu autochtone dans les cours et les programmes en enseignement de la géographie et de l’histoire au primaire et au secondaire.<br>
		<br>
		La collection ethnographique du département d'anthropologie de l’UdeM compte un riche corpus d'environ 500 objets associés aux Premiers Peuples du Canada, provenant en particulier de communautés atikamekw nehirowisiwok, innu et inuit. En contexte scolaire, ces objets ont le potentiel d’intéresser les jeunes à l’histoire, à la compréhension des sociétés et des territoires, au développement d’un intérêt pour le patrimoine et d’une sensibilité culturelle.<br>
		<br>
		Un des volets du projet a donné lieu à la captation audiovisuelle de rencontres avec des personnes porteuses de savoirs culturels dans la réserve de la collection qui montrent la richesse des échanges autour de la culture matérielle et immatérielle des Premiers Peuples.<br>
		<br>
		Ce projet a pu voir le jour grâce au soutien du Vice-rectorat à la planification et à la communication stratégiques (VRPCS) et du ministère de l’Enseignement supérieur (MES). De plus, il est le fruit d’une riche collaboration avec la responsable de la collection, Violaine Debailleul, des collègues de l’organisme autochtone La Boîte Rouge VIF, Marilyne Soucy et Jean-François Vachon, ainsi que les acteurs du projet Ivirtivik, une initiative de l’Administation Régionale Kativik, dédiée à la communauté inuit.</p>
		
		<p class='italique plusPetit'>*Il est à noter que l’absence d’accord en genre et en nombre des ethnonymes est volontaire dans cette page Web. Ce choix s’inscrit dans une perspective de réduire et même de faire disparaître les rapports de pouvoir et l’influence des schèmes de pensée occidentaux sur les cultures autochtones.</p>
		
		<h2 id="expertsInvites" onclick="ouvrir(this.id)">Les porteurs de savoirs culturels</h2>
			<div class='colonnesVariables'>
				<div>
					<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/Jacques.jpg');" onclick="afficherContenu(2);" class="videoCliquable"></div>
					<p>Jacques, Atikamekw nehirowisiw</p>
				</div>
				<div>
					<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/Samuel.jpg');" onclick="afficherContenu(3);" class="videoCliquable"></div>
					<p>Samuel, Innu</p>
				</div>
				<div>
					<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/Jean.jpg');" onclick="afficherContenu(4);" class="videoCliquable"></div>
					<p>Jean, Innu</p>
				</div>
				<div>
					<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/Shauna.jpg');" onclick="afficherContenu(5);" class="videoCliquable"></div>
					<p>Shauna, Inuk</p>
				</div>
				<div>
					<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/Tapia.jpg');" onclick="afficherContenu(6);" class="videoCliquable"></div>
					<p>Tapia, Inuk</p>
				</div>
				<div>
					<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/Piatsi.jpg');" onclick="afficherContenu(7);" class="videoCliquable"></div>
					<p>Piatsi, Inuk</p>
				</div>
				<div>
					<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/Moses.jpg');" onclick="afficherContenu(8);" class="videoCliquable"></div>
					<p>Moses, Inuk</p>
				</div>
			</div>
			
		<h2 id="rencontres" onclick="ouvrir(this.id)">Les rencontres : des espaces de dialogue où l’objet est central</h2>
			<div>
				<p>Dans ces vidéos, des porteurs de savoirs culturels atikamekw, innu et inuit partagent connaissances et souvenirs à partir d’objets choisis pendant les visites. Ils nous amènent à la rencontre du territoire et de ses ressources, nous transmettant au passage valeurs, savoirs et savoir-faire millénaires.</p>
				
				<p class='italique plusPetit'>*Pour cibler les thèmes discutés, vous n'avez qu'à placer votre curseur sur les séquences de la vidéo… Certains clips ont été filmés en 360 degrés, n'hésitez pas à changer de perspective pour avoir un aperçu de l'ensemble de la réserve.<br><br></p>
				
				<div class='colonnesVariables jour jour1'>
					<div>
						<p>Mettre les bases</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/bases.jpg');" onclick="afficherContenu(9);" class="videoCliquable"></div>
					</div>
					<div>
						<p>Exploration libre</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/exploration.jpg');" onclick="afficherContenu(10);" class="videoCliquable"></div>
					</div>
					<div>
						<p>Premières impressions</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/premieresImpressions.jpg');" onclick="afficherContenu(11);" class="videoCliquable"></div>
					</div>
					<div>
						<p>En réserve 1</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/reserve1.jpg');" onclick="afficherContenu(12);" class="videoCliquable"></div>
					</div>
					<div>
						<p>Des objets spécifiques 1</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/objetsSpecifiques1.jpg');" onclick="afficherContenu(13);" class="videoCliquable"></div>
					</div>
				</div>
				
				<div class='colonnesVariables jour jour2'>
					<div>
						<p>En réserve 2</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/reserve2.jpg');" onclick="afficherContenu(14);" class="videoCliquable"></div>
					</div>
					<div>
						<p>À l’UdeM</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/UdeM.jpg');" onclick="afficherContenu(15);" class="videoCliquable"></div>
					</div>
					<div>
						<p>Des objets spécifiques 2</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/objetsSpecifiques2.jpg');" onclick="afficherContenu(16);" class="videoCliquable"></div>
					</div>
				</div>
				
				<div class='colonnesVariables jour jour3'>
					<div>
						<p>En réserve 3</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/reserve3.jpg');" onclick="afficherContenu(17);" class="videoCliquable"></div>
					</div>
					<div>
						<p>Des objets spécifiques 3</p>
						<div style="background-image:url('https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/objetsSpecifiques3.jpg');" onclick="afficherContenu(18);" class="videoCliquable"></div>
					</div>
				</div>
			</div>
			
		<div class='fondGris'>
			<h2>Approches pédagogiques et stratégies à explorer en classe</h2>
				<h3>Apprendre par les objets en milieu scolaire et universitaire pour s’ouvrir aux perspectives autochtones</h3>
					<p>À partir des images des objets (1), puisant ensuite dans leurs fiches descriptives et faisant finalement appel aux vidéos présentées dans la section LES RENCONTRES où le partage d’experts culturels sur ces objets fournissent un éclairage supplémentaire (2), nous vous proposons cette séquence d’actions à réaliser avec vos élèves en classe.<br></p>
					
			<a href='https://collectionethno.umontreal.ca/Gallery/53' target='_blank'><img src="https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/education.jpg" width='100%'></a>
			<p class='italique plusPetit'>Pour en savoir plus sur les biens culturels discutés, cliquez sur la mosaïque d’objets afin d’ouvrir un lien vers la collection présentant ces objets, leurs fiches descriptives et des images, dont certaines en 360 degrés.</p>
			
			<hr>
			
			<p class='citation light'><span class='fauxTitre'>1.</span>Explorer – observer l’objet :<br>
			<span class='petitGrasItalic'>Nous sommes ici au stade de l’hypothèse, les inférences, les discussions...</span>
			
			<span class='alinea'>Quels sont les matériaux utilisés?<br>
			Qui l’a fabriqué, à quelle époque, à quel endroit?<br>
			L’objet avait quelle fonction? Qui l’utilisait?</span><br>
			
			<span class='fauxTitre'>2.</span>Rechercher sur l’objet :<br>
			<span class='petitGrasItalic'>C’est le début de l’enquête pour trouver des réponses aux questions...</span></p>
			
			<table>
				<tr>
					<th colspan='100%'>Nom de l’objet :</th>
				</tr>
				<tr>
					<td>Matériaux&nbsp;?</td>
					<td>Origine&nbsp;?<br><span class='light'>Fabriqué par&nbsp;? Quelle époque&nbsp;? Où&nbsp;?</span></td>
					<td>Fonction&nbsp;?<br><span class='light'>Sert à&nbsp;? Utilisé par&nbsp;? Dans quel contexte&nbsp;?</span></td>
				</tr>
				<tr>
					<td colspan='100%'>Que nous apprend cet objet sur les sociétés qui l’ont fabriqué et utilisé&nbsp;?<br>
					<span class='light'>À partir de votre recherche et du visionnement de la vidéo...</span></td>
				</tr>
				<tr>
					<td colspan='100%'>Quel lien pouvons-nous faire entre cet objet et le territoire&nbsp;?</td>
				</tr>
				<tr>
					<td colspan='100%'>À la suite de vos observations et de votre enquête, quelles questions demeurent sans réponse sur cet objet&nbsp;?<br>
					Avez-vous de nouvelles questions sur cet objet et sur les individus qui l’ont conçu et utilisé&nbsp;?</td>
				</tr>
				<tr>
					<td colspan='100%'>Cet objet est-il encore utilisé de la même façon aujourd’hui&nbsp;?<br>
					Si oui, par qui et comment&nbsp;? Sinon, pourquoi&nbsp;?</td>
				</tr>
			</table>
			
			<p class='citation light'><span class='fauxTitre'>3.</span>Et si vous deviez apporter un objet de la maison et en faire sa biographie...<br>
			<br class='demiLigne'>
			<span class='alinea'>Amener les élèves à refaire le même chemin que les deux étapes précédentes.<br>
			<br class='demiLigne'>
			Encourager les élèves à préparer leur enquête à l’aide de livres, de sites internet et d’entrevues avec des membres de leur famille ou de personnes liées à l’objet.<br>
			<br class='demiLigne'>
			Amener les élèves à communiquer le fruit de leur investigation à l’aide du numérique (balado, outil de présentation comme PPT ou Canva, etc.).</span></p>
		</div>
		<div class='fondGris'>
			<p class='citation'><span class='trait'>Observation, manipulation, hypothèses, interprétation</span>
			<b>Français; histoire; sciences; arts; biologie; géographie</b><br>
			<br>
			<span class='trait'>L'objet pour réfléchir à l'aménagement du territoire</span>
			<b>Empathie et agentivité</b></p>
		</div>
	</div>
	
	<footer>
		<img src="https://umontreal.whirlihost.com/media/collectiveaccess/images/Education/LogoBRV.png" class='logos'>
	</footer>
	
	<script>
	/* Ouvrir et fermer les vidéos pour le mobile */
		function ouvrir(element)
		{
			let titre = document.getElementById(element);
			
			titre.classList.add('ouvert');
			titre.removeAttribute("onclick");
			titre.setAttribute("onclick", "fermer(this.id)");
			
			titre.nextElementSibling.style.display = "grid";
		}
		
		function fermer(element)
		{
			let titre = document.getElementById(element);
			
			titre.removeAttribute("class");
			titre.removeAttribute("onclick");
			titre.setAttribute("onclick", "ouvrir(this.id)");
			
			titre.nextElementSibling.removeAttribute("style");
		}
		
	/* Contenu vidéo */
		const contenus = [["Lien", "Titre"],
		["1102976467?h=78a69a81c4", "L’apprentissage basé sur les objets"],
		["1102969650?h=cbfbeafd14", "Jacques, Atikamekw nehirowisiw"],
		["1102969871?h=47e47349d4", "Samuel, Innu"],
		["1102960735?h=d311799bf9", "Jean, Innu"],
		["1102961046?h=0a123fe04e", "Shauna, Inuk"],
		["1102961057?h=6919264126", "Tapia, Inuk"],
		["1102961069?h=e2de6b464d", "Piatsi, Inuk"],
		["1102961077?h=20a3c60d04", "Moses, Inuk"],
		["1102961090?h=a79a3ec9b2", "Mettre les bases"],
		["1102961630?h=af07f52888", "Exploration libre"],
		["1102962079?h=49b4d19da7", "Premières impressions"],
		["1103018652?h=f0117b8c75", "En réserve 1"],
		["1102963659?h=8a79a274aa", "Des objets spécifiques 1"],
		["1103010034?h=236f2681d3", "En réserve 2"],
		["1102964314?h=d9a4c2962f", "À l’UdeM"],
		["1112114608?h=3f7aa6426c", "Des objets spécifiques 2"],
		["1103024882?h=c851e00647", "En réserve 3"],
		["1102964768?h=0447584463", "Des objets spécifiques 3"]/*,
		["1102967293?h=e011cf1fc6", "Approche pédagogique envisagée"]*/];
		
		const popUp = document.getElementById("popUp");
		function afficherContenu(contenuNo)
		{
			popUp.classList.add("contenuAffiche");
			
			document.getElementById("iframeVimeo").src = "https://player.vimeo.com/video/" + contenus[contenuNo][0] + "&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479";
			document.getElementById("titresVideos").innerHTML = contenus[contenuNo][1];
			document.getElementById("iframeVimeo").title = contenus[contenuNo][1];
		}
		
	/* Fermer lorsqu'on clique sur ECHAP/ESC */
		window.onkeydown = function(event)
		{
			if(event.keyCode == 27)
			{
				popUp.removeAttribute("class");
			}
		};
		
		function fermerPopUp()
		{
			popUp.removeAttribute('class');
			document.getElementById("iframeVimeo").src = "";
		}
	</script>
</body>
</html>