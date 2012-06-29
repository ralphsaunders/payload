<!doctype html>
<html>
    <head>
        <title>
            <?php if( isset( $title ) ) { echo $title; } ?>
        </title>

        <?php $this->load->helper( 'url' ); ?>
        <link href="<?php echo base_url(); ?>assets/css/styles.css" type="text/css" rel="stylesheet">

        <!-- Typekit -->
        <script type="text/javascript" src="http://use.typekit.com/roi3hdr.js"></script>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    </head>
    <body>
