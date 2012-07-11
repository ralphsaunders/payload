$( document ).ready( function() {
    $( '.masthead-heading' ).lettering();
});

$( document ).ready( function() {

    $( '.masthead .logo' ).click( function() {

        var offsetHeight = 300;

        $( this ).animate({
            marginTop : [ -offsetHeight, 'swing' ]
        },
        {
            duration: 3000,
            step: function( now, fx ) {
                var currentPosition = $( this ).position();
                var offsetByX = Math.floor( Math.random() * 8 );
                var offsetByY = Math.floor( Math.random() * 8 );

                if( now % 2 == 0 )
                {
                    $( this ).css({ 'marginTop' : -offsetByY, 'marginLeft' : offsetByX });
                } else {
                    $( this ).css({ 'marginTop' : offsetByY, 'marginLeft' : -offsetByX });
                }

                $( '.masthead-heading' ).children().each( function() {
                    jitter( $( this ), 3, now );
                });


                if( -now === offsetHeight ) {
                    window.setTimeout( function(){ reset(); }, 2000 );
                }
            }
        });
    });

    function jitter( element, multiplier, i ) {
        if( i % 2 == 0 && i > -160 ) {
            $( element ).css({
                'marginTop'  : - Math.floor( Math.random() * multiplier ),
                'marginLeft' :   Math.floor( Math.random() * multiplier / 2 )
            });
        } else if( i % 2 != 0 && i > -160 ) {
            $( element ).css({
                'marginTop'  :   Math.floor( Math.random() * multiplier ),
                'marginLeft' : - Math.floor( Math.random() * multiplier / 2)
            });
        }

        console.log( i );
    }

    function reset() {
        $( '.masthead .logo' ).hide();
        $( '.masthead .logo' ).css( 'marginTop', '0' );
        $( '.masthead-heading' ).children().css( 'marginTop', '0' );
        $( '.masthead .logo' ).fadeIn( 300 );
    }
});
