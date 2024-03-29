<!doctype html>
<html>
    <head>
        <title>
            <?php if( isset( $title ) ) { echo $title; } ?>
        </title>

        <?php $this->load->helper( 'url' ); ?>
        <?php if( current_url() != base_url() ): ?>
        <!-- Payload's Default CSS -->
        <link href="<?php echo base_url(); ?>assets/css/styles.css" type="text/css" rel="stylesheet">
        <?php endif; ?>

        <!-- Default Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

        <!-- Default iOS Device Icons -->
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/images/apple-touch-icon.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/images/touch-icon-retina.png" />
        <link rel="apple-touch-icon" sizes="72x72"   href="<?php echo base_url(); ?>assets/images/touch-icon-ipad.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/images/touch-icon-retina-ipad.png" />

    </head>
    <body>
