<?php

function error( $messages )
{
    if( is_array( $messages ) )
    {
        foreach( $messages as $name => $message )
        {
            $errors[$name] = $message;
        }
    }
    else if( is_string( $messages ) )
    {
        $errors = array( 'error', $messages );
    }
    else
    {
        $errors = "Error messages must be types string and array only";
    }

    return array( 'errors' => $errors );
}

?>
