<section class="pl-grids">
    <section class="pl-grids-1">

<?php
if( is_array( $errors ) ):
    foreach( $errors as $title => $message ) : ?>

<hgroup>
    <h4>Error: <?php echo $title; ?></h4>
    <h5><?php echo $message; ?></h5>
</hgroup>

<?php
    endforeach;
else:
    echo $errors;
endif;
?>

    </section>
</section>
