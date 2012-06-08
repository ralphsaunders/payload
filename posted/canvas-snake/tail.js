$( document ).ready( function() {

    // Our namespace
    var snake = function() {

        /**
         * canvas
         *
         * Selects canvas element via ID canvas.
         * Canvas holds our drawing plane.
         *
         * @type DOM object
         */
        var canvas = document.getElementById( 'canvas' );

        /**
         * draw
         *
         * The drawing plane for canvas. This is what we manipulate when
         * drawing/clearing stuff. Example:
         *
         *      draw.fillRect( 20, 20, 100, 100 );
         *
         *      Draws a rectangle at x:20, y:20 with a width of 100px and a height
         *      of 100px.
         */
        var draw = canvas.getContext( '2d' );

        /**
         * Unit
         *
         * This is the 'unit' of measure that defines the grid of our snake
         * game.
         */
        var unit = 20;

        /**
         * Coordinates
         *
         * Array holds x and y coordinates
         */
        var coords = new Array();
        coords = generateRandomCoords();

        /**
         * tock
         *
         * Bool that helps keep track of whether coords have been modified but
         * tick hasn't updated yet.
         */
        var tock = true;

        /**
         * keys
         *
         * Array holds a list of keycodes
         *
         * [ w, up arr ], [ a, left arr ], [ s, down arr ], [ d, right arr ]
         */
        var keys = [ [ 87, 38 ], [ 37, 65 ], [ 40, 83 ], [ 39, 68 ] ];

        /**
         * direction
         *
         * String keeps track of direction.
         *
         * Up    : 'up'
         * Left  : 'left'
         * Down  : 'down'
         * Right : 'right'
         *
         */
        var direction = 'right';

        /**
         * Past coordinates
         *
         * Array holds past coordinates for snake's head. The segments use this
         * for positioning.
         */
        var pastCoords = new Array();

        /**
         * segments
         *
         * Array used to keep track of the number of body segments the snake
         * has.
         */
        var segments = new Array();
        segments.push( '1' ); // Initial body


        /**
         * Change Direction
         *
         * Modifies direction based on key press. Only listens to one keypress
         * per tock (reset in tick()).
         */
        function changeDirection( e ) {

            /**
             * Loop through all recorded keycodes in the keys array. If the key
             * pressed matches one of the keycodes then we'll prevent its
             * default function.
             */
            for( i = 0; i < keys.length; i++ ) {
                if( e.which == keys[i][0] || e.which == keys[i][1] ) {
                    e.preventDefault();
                }
            }

            if( tock ) {

                /**
                 * Check the keycode for the pressed key against the keys in our
                 * array.
                 */
                if( e.which == keys[0][0] || e.which == keys[0][1] ) { // Up
                    direction = 'up';
                } else if( e.which == keys[1][0] || e.which == keys[1][1] ) { // Left
                    direction = 'left';
                } else if( e.which == keys[2][0] || e.which == keys[2][1] ) { // Down
                    direction = 'down';
                } else if( e.which == keys[3][0] || e.which == keys[3][1] ) { // Right
                    direction = 'right';
                }

                tock = false;
            }
        }

        /**
         * Generate Random Coords
         *
         * Generates random x & y coordinates in multiples of our 'unit'.
         *
         * @return array[ int, int ]
         */
        function generateRandomCoords() {
            /**
             * The functions:
             * Math.round() is used to round a number to its nearest whole
             * number. We do this because pixels can only be whole numbers.
             *
             * Math.floor rounds the number *down* to its nearest whole number.
             *
             * Math.random() generates a random number between 0 and 1.
             *
             * What's going on:
             *
             *      We want to generate a random number between 0 and the width
             *      of the canvas.
             *
             *      If we just multipled Math.random() by
             *      canvas.width we might get a number at the extreme right of
             *      the canvas. Shapes are drawn from the top-left, so an
             *      x-coordinate at the far right of the canvas will cause our
             *      shape to be drawn off-screen. To counter this, we remove
             *      almost an entire unit's value from the canvas.width value.
             *
             *      Math.random() * (canvas.width - ( unit - 1 ) )
             *
             *
             *      Once we've got our base value, we round it down to a whole
             *      number and then divide that by our unit, in turn rounding
             *      that to a whole number. The reason we do this is because we
             *      only want to generate values that are multiples of our unit.
             *
             *      Math.round(
             *          Math.floor(
             *              Math.random() * (
             *                  canvas.width - ( unit - 1 )
             *              )
             *          )
             *          / unit
             *      )
             *
             *      To finish we then multiply this rounded figure up again by
             *      the unit so we have a value that can represent any point on
             *      the canvas given that it's a multiple of our unit.
             *
             *      Math.round(
             *          Math.floor(
             *              Math.random() * (
             *                  canvas.width - ( unit - 1 )
             *              )
             *          )
             *          / unit
             *      )
             *      * unit;
             */
            var x = Math.round( Math.floor( Math.random() * ( canvas.width  - ( unit - 1 ) ) ) / unit ) * unit;
            var y = Math.round( Math.floor( Math.random() * ( canvas.height - ( unit - 1 ) ) ) / unit ) * unit;

            return [ x, y ];
        }

        /**
         * Update Coordinates
         *
         * Moves snake's head based on direction. Also moves snake's head to the
         * other side of the canvas if the next coordinates cause it to go
         * off-screen.
         *
         * @param array[x, y]
         */
        function updateCoords( origin ) {

            updatePastCoords();



            if( direction == 'up' ) {
                origin[1] -= unit;
            } else if( direction == 'left' ) {
                origin[0] -= unit;
            } else if( direction == 'down' ) {
                origin[1] += unit;
            } else if( direction == 'right' ) {
                origin[0] += unit;
            }

            // Reset snakes head if it has gone out of bounds
            if( origin[0] < 0 ) {
                origin[0] = canvas.width - unit;
            } else if( origin[0] + unit > canvas.width ) {
                origin[0] = 0; // No need to add unit because head is drawn from topLeft
            }

            if( origin[1] < 0 ) {
                origin[1] = canvas.height - unit;
            } else if( origin[1] + unit > canvas.height ) {
                origin[1] = 0; // No need to add unit because head is drawn from topLeft
            }
        }

        /**
         * Update Past Coordinates
         *
         * Manages pastCoords array
         */
        function updatePastCoords() {
            /**
             * Push an array containing x & y coordinates to the pastCoords
             * array.
             *
             *      pastCoords.push( [x, y] )
             */
            pastCoords.push( [ coords[0], coords[1] ] );

            /**
             * We need to trim the pastCoords array when it gets too long.
             *
             * If the length of our pastCoords array is more than the length of
             * our snake's body...
             */
            if( pastCoords.length > segments.length ) {

                /**
                 * Remove 1 element of our array from index 0.
                 *
                 *      pastCoords[0] == 'foo'
                 *      pastCoords[1] == 'bar'
                 *      pastCoords[2] == 'baz'
                 *
                 *      becomes:
                 *
                 *      pastCoords[0] == 'bar'
                 *      pastCoords[1] == 'baz'
                 */
                pastCoords.splice( 0, 1 );
            }
        }

        /**
         * Draw Snake
         *
         * Draws rectangle(s) onto the canvas when given x and y coords in an
         * array.
         *
         * @param array[x, y]
         */
        function drawSnake( origin ) {
            // The head of our snake
            draw.fillStyle = "rgb( 20, 151, 245)";
            draw.fillRect( origin[0], origin[1], 20, 20 );

            // body segments
            for( i = 0; i < segments.length; i++ ) {
                if( i < 5 ) {
                    /**
                     * We're adjusting our fill style based on the loops index.
                     *
                     * The fourth value in rgba() stands for alpha, which is how
                     * transparent the fill is. The closer the alpha value is to
                     * 1, the less transparent it is.
                     */
                    draw.fillStyle = "rgba( 20, 151, 245, 0." + ( i + 3 ) + " )";
                } else {
                    draw.fillStyle = "rgba( 20, 151, 245, 0.7 )";
                }
                draw.fillRect( pastCoords[i][0], pastCoords[i][1], 20, 20 );
            }
        }

        function tick() {

            // Clear the entire canvas
            draw.clearRect( 0, 0, canvas.width, canvas.height );

            /**
             * We only want the player to be able to issue one direction command
             * per tick.
             */
            tock = true;

            // Listen for keydown event
            $( document ).keydown( function( e ) {
                changeDirection( e );
            });

            updateCoords( coords );
            drawSnake( coords );

            if( segments.length < 8 ) {
                segments.push( 'foo' );
            }

            /**
             * This timeout will call its parent function, tick(), ever 100ms, thus
             * looping on itself
             */
            setTimeout( function() { tick() }, 100 );
        }

        return {

            /**
             * Init
             *
             * Accessed via snake.init(), this function is a handle for the
             * snake namespace.
             */
            init : function() {

                /**
                 * Here we refer to the tick() fuction within the snake namespace.
                 * We only want to call init() once, so tick() will have to loop on
                 * itself
                 */
                tick();
            }

        };

    }();

    snake.init();

});
