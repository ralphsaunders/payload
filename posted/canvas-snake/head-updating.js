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
         * Increments x coordinate by unit
         *
         * @param array[x, y]
         */
        function updateCoords( origin ) {

            // Increment our x coordinate
            origin[0] += unit;

            /**
             * If the x coordinate on the next tick will be more than our
             * canvas' width ( i.e. off-screen ) reset it to 0, moving it to the
             * far left of the canvas.
             */
            if( origin[0] + unit > canvas.width ) {
                origin[0] = 0;
            }
        }

        /**
         * Draw Snake
         *
         * Draws rectangle(s) onto the canvas when given x and y coords in an
         * array.
         *
         * @access private
         * @param array[x, y]
         */
        function drawSnake( origin ) {
            // The head of our snake
            draw.fillStyle = "rgb( 20, 151, 245)";
            draw.fillRect( origin[0], origin[1], 20, 20 );
        }

        function tick() {

            // Clear the entire canvas
            draw.clearRect( 0, 0, canvas.width, canvas.height );

            updateCoords( coords );
            drawSnake( coords );

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
