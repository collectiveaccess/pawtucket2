<?php
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
	if ($va_result_count > 0) {
?>
		<section id="busquedas-relacionadas" class="col1">
                
		<h3 class="titulo"><?php print _t("También corresponden a %1", '<span class="azul">'.$this->getVar('search').'</span>'); ?></h3>
                
		<div class="mascara">
                    
			<div class="articulos"><div class="jcarousel-wrapper" style="width:1000px;"><div class="jcarousel" id="secondarySearchesCarousel"><ul class='jcarousel-list'>
<?php
		// 
		// Print out block content (results for each type of search)
		//
		$i = 0;
		foreach($this->getVar('blockNames') as $vs_block) {
			if($i == 0){
				print "<li class='jcarousel-item'>";
			}
			print $va_results[$vs_block]['html'];
			$i++;
			if($i == 4){
				$i = 0;
				print "</li>";
			}
		}
		if($i > 0){
			print "</li>";
		}
?>			
				</ul></div><!-- end jcarousel --></div><!-- end jcarousel-wrapper -->
			</div><!-- end articulos -->
		</div><!-- end mascara -->
                
		<a href="#" class="items btnLeft" id="detailScrollButtonPreviousSecSearch">left</a>
                <a href="#" class="items btnRight" id="detailScrollButtonNextSecSearch">right</a>
            
	</section>
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('#secondarySearchesCarousel')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPreviousSecSearch')
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
					$('#detailScrollButtonNextSecSearch')
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
				
				
				
					var dispositivo = navigator.userAgent.toLowerCase();
					if( dispositivo.search(/iphone|ipod|ipad|android/) < 0 ){
						//Scroll Vertical
						if($('.scrollArea2').length>0){
							$('.scrollArea2').css('overflow','hidden').append('<div class="areaScroll"><div class="arrastraScroll"></div></div>');
							$.each($('.scrollArea2 ul'), function(index,value){
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
				
				
				
				});
			</script>	
<?php		
	}
?>