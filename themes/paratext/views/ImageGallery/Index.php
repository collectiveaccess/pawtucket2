<?php
$images = array(
    array(
        'image'         => '71065583.jpg',
        'thumbnail'     => '71065583_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Comedias Sueltas Gallery 8.jpg',
        'thumbnail'     => 'Comedias Sueltas Gallery 8_S.jpg',
        'caption'       => ' <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus maximus, magna vel dapibus eleifend, ex nibh malesuada turpis, in pulvinar lectus mauris et elit. Nulla facilisi. Curabitur accumsan sed ante vel vehicula. Praesent sit amet dolor eget turpis feugiat tincidunt sit amet id nisl. Fusce porttitor convallis ipsum, nec dignissim turpis dictum ut. Cras volutpat fringilla turpis, non hendrerit risus. Nullam suscipit lectus nisi, in interdum mauris varius sed. Ut eget tempus dui. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas mauris nunc, elementum vel elit sed, vehicula rhoncus sapien. Nullam non magna fermentum mauris ultrices rhoncus. In tempor elementum iaculis. Vivamus gravida dui a risus venenatis, a posuere enim semper.</p>
        <p>Suspendisse dui metus, rhoncus maximus consequat et, mollis in elit. Phasellus sed tincidunt est. Donec eleifend, nisl sed iaculis imperdiet, massa odio convallis lectus, et volutpat eros nibh non magna. Praesent lobortis nulla urna, nec scelerisque augue varius ut. Praesent vitae dui in turpis venenatis egestas vel at velit. Cras eget massa hendrerit, pharetra odio ac, vehicula eros. Nulla non commodo sapien.</p>
        <p>Praesent ullamcorper posuere tincidunt. Mauris posuere odio et bibendum accumsan. Cras consectetur consectetur sapien at varius. Quisque varius dui nisl, vel suscipit eros ornare nec. Fusce quis nibh dapibus, viverra quam id, faucibus mauris. Mauris in luctus sem, vel dapibus eros. Integer lobortis porttitor nisl, sed semper dui sollicitudin in. Mauris pretium tellus magna, a volutpat lacus tincidunt sit amet. Sed blandit odio at lorem euismod, vel euismod dui auctor. Suspendisse dapibus tortor id est viverra pretium. Vivamus lacinia metus nec sem rutrum, vel molestie dolor mollis. Maecenas aliquam aliquet gravida. Maecenas sit amet eros sed sem vestibulum mollis. Proin nulla erat, tincidunt facilisis ipsum vel, hendrerit dignissim ex.</p>',
    ),
    array(
        'image'         => 'Comedias Sueltas Gallery 11.jpg',
        'thumbnail'     => 'Comedias Sueltas Gallery 11_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Comedias Sueltas Gallery 14.jpg',
        'thumbnail'     => 'Comedias Sueltas Gallery 14_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Imprenta-Municipal-talleres-tipografia-letterpress-blog-minke.jpg',
        'thumbnail'     => 'Imprenta-Municipal-talleres-tipografia-letterpress-blog-minke_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Home Image 1 duotone.png',
        'thumbnail'     => 'Home Image 1 duotone_S.png',
        'caption'       => '',
    ),
    array(
        'image'         => 'Home Image 2 duotone.jpg',
        'thumbnail'     => 'Home Image 2 duotone_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Home Image 3 duotone.jpg',
        'thumbnail'     => 'Home Image 3 duotone_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Antonio de Sacha.jpg',
        'thumbnail'     => 'Antonio de Sacha_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Home Image 5 duotone.jpg',
        'thumbnail'     => 'Home Image 5 duotone_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'La librera de Goya.jpg',
        'thumbnail'     => 'La librera de Goya_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'baixada de la canonja.jpg',
        'thumbnail'     => 'baixada de la canonja_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Lonja de la seda Valencia.jpg',
        'thumbnail'     => 'Lonja de la seda Valencia_S.jpg',
        'caption'       => '',
    ),
    array(
        'image'         => 'Miguelete Valencia.jpg',
        'thumbnail'     => 'Miguelete Valencia_S.jpg',
        'caption'       => '',
    ),
);
?>

<div class="swiper-container gallery_main">
    <div class="swiper-wrapper main">

        <?php
        foreach($images as $image) { ?>
            <div class="swiper-slide">
                <div class="columns">
                    <div class="left">
<?php
				print caGetThemeGraphic($this->request, 'img/'.$image['image'], array("class" => "swiper-lazy", "alt" => "Larger version of: ".$image['caption']));
?>
                    </div>
                    <div class="right">
                        <div class="caption">
                            <?= $image['caption']; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    <div class="swiper-button-next"><div class="arrow"></div></div>
    <div class="swiper-button-prev"><div class="arrow"></div></div>
</div>
<div thumbsSlider="" class="swiper-container gallery_thumbnails">
    <div class="swiper-wrapper thumbnails">

        <?php
        foreach($images as $image) { ?>
            <div class="swiper-slide">
<?php
				print caGetThemeGraphic($this->request, 'img/'.$image['thumbnail'], array("alt" => $image['caption']));
?>
            </div>
        <?php } ?>

    </div>
</div>