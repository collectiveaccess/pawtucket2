var valform;

$(document).ready(function(){
	var aceptaCookies = false;
	var listaCookies = document.cookie.split(";");
	for (i in listaCookies) {
	    busca = listaCookies[i].search("acepta_cookies");
	    if (busca > -1) aceptaCookies=true;
    }
	(!aceptaCookies)? $('.hideMenu').css('marginTop',$('#politica_cookies').height()):$('#politica_cookies').hide();


	$('a').on('click',function(){
		if(!$(this).hasClass('txtPolCookies')) document.cookie = "acepta_cookies=pdc; max-age="+60*60*24*30+"; path=/";
	})
	$('.cerrarCookies').on('click',function(){
		$('#politica_cookies').hide();
		$('.hideMenu').css('marginTop',0);
		return false;
	})
	
	$( document ).tooltip();
	$('#mainHome .active header').show();
	$('#mainHome .active figure').css('marginRight',255);
	//funcionamiento de formularios
	$('input[type=text],select').on('click', limpiaForm);
	function limpiaForm(){
		if($(this).val()=='Contraseña' || $(this).val()=='*Contraseña' || $(this).val()=='*Confirma contraseña'){
			$(this).attr('type','password');
		}else{
			if($(this).change()){
				valform = $(this).val();
				$(this).on('focusout',reestableceForm);
			}
		}
		$(this).val('').addClass('negro');
		$(this).off('click');
	}
	function reestableceForm(){
		if($(this).val()==''){
			$(this).val(valform).removeClass('negro');
			$(this).on('click',limpiaForm);
		}
	}
	
	//acción del boton explorar de la home
	$('.btnExplorar').on('click',muestraExplorar);
	function muestraExplorar(){
		($(this).hasClass('explorar'))? $(this).removeClass('explorar'):$(this).addClass('explorar');
		$('#explorarHome').slideToggle();
		return false;
	}
	
	$('.botonIzq').on('click', mueveLeft);
	function mueveLeft(){
		var elemento = $(this).prev().find('.articulos');
		var posicion = elemento.css('left');
		var ancho = $(this).prev().width();
		if(posicion=='auto' || posicion>0){
			posicion = 0;
		}else{
			posicion = Number(posicion.substring(0,posicion.indexOf('px')));
		}
		elemento.animate({left:posicion+ancho},500);
		return false;
	}
	$('.botonDer').on('click', mueveRight);
	function mueveRight(){
		var elemento = $(this).prev().find('.articulos');
		var posicion = $(this).prev().prev().find('.articulos').css('left');
		var ancho = $(this).prev().prev().width();
		if(posicion=='auto'){
			posicion = 0;
		}else{
			posicion = Number(posicion.substring(0,posicion.indexOf('px')));
		}
		$(this).prev().prev().find('.articulos').animate({left:posicion-ancho},500);
		return false;
	}
	
	$('.pause').on('click',cambiapause);
	function cambiapause(){
		$(this).hide();
		$('.play').css('display','inline-block');
		return false;
	}
	$('.play').on('click',cambiaplay);
	function cambiaplay(){
		$(this).hide();
		$('.pause').css('display','inline-block');
		return false;
	}
	$('.close').on('click',cierraVelo);
	function cierraVelo(){
		$('#diaporama').fadeOut(500);
		$('#velo').delay(400).fadeOut(400);
		return false;
	}
	$('.btnDiaporama').on('click',abreVelo);
	function abreVelo(){
		$('#velo').fadeIn(400);
		$('#diaporama').delay(400).fadeIn(500);
		return false;
	}
	
	var dispositivo = navigator.userAgent.toLowerCase();
	if( dispositivo.search(/iphone|ipod|ipad|android/) < 0 ){
		//Scroll Vertical
		if($('.scrollArea').length>0){
			$('.scrollArea').css('overflow','hidden').append('<div class="areaScroll"><div class="arrastraScroll"></div></div>');
			$.each($('.scrollArea ul'), function(index,value){
				var altoContenedor = $(this).parent().height()-40;
				var altoElementos = $(this).height()-altoContenedor;
				var contenedor = $(this);
				contenedor.next().height(altoContenedor).find('.arrastraScroll').draggable({ containment: 'parent', drag: calculaPosicion });
	
				function calculaPosicion(e,ui)
				{
					contenedor.css('top',-ui.position.top*altoElementos/(altoContenedor-40));
				}
			})
	
		}
		//Scroll Horizontal
		if($('.scrollXArea').length>0){
			var anchoMiniaturas = $('.scrollXArea .miniaturas li').length*107-$('.scrollXArea').parent().width();
			$('.scrollXArea').css('overflow','hidden').append('<div class="areaXScroll"><div class="arrastraXScroll"></div></div>');
			$('.arrastraXScroll').draggable({ containment: 'parent', drag: calculaPosicionX });
			function calculaPosicionX(e,ui)
			{
				$('.scrollXArea').find('.articulos').css('left',-ui.position.left*anchoMiniaturas/560);
			}
		}
	}else{
		$('nav .pestana').on('click',activaNav);
		var navActive = 0;
		function activaNav(){
			if(navActive == 0){
				$('nav').css({top:0}).find('.flechaBlanca').css({'transform':'rotate(180deg)','-webkit-transform':'rotate(180deg)'});
				navActive = 1;
			}else{
				$('nav').css({top:-52}).find('.flechaBlanca').css({'transform':'rotate(0deg)','-webkit-transform':'rotate(0deg)'});
				navActive = 0;
			}
		}
	}
	
	//mainHome
	$('.fotoinfo').on('click',muestraInfo);
	function muestraInfo(){
		var elemento = $(this).parents('article');
		var ancho = $(this).parent().width();
		elemento.parent().find('.active header').fadeOut(400);
		elemento.find('figure').animate({marginRight:255},1000);
		elemento.parent().find('figure').not(elemento.find('figure')).animate({marginRight:0},950,function (){
			elemento.parent().find('.active').removeClass('active');
			elemento.addClass('active').find('header').css('left',elemento.position().left+ancho+20).fadeIn(600);
		});
	
		if($(this).hasClass('miniarticulo')){
			if($('#mainHome .fotoinfo').index($(this)) == 2){
				$('#mainHome article:eq(1)').delay(300).fadeOut(200);
				$('#mainHome article:eq(2)').delay(300).fadeOut(200,cambiaArticulos);
			}
		}
		return false;
	}
	function cambiaArticulos(){
		$('.articuloVisto:eq(0)').append($('#mainHome article:eq(1)'));
		$('#mainHome article:eq(1),#mainHome article:eq(2)').fadeIn(500);
	}
})