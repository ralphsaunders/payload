<?php

/**
 * Title Case
 *
 * Turns /path-to-files/ to Path To Files
 *
 * @param  string
 * @return string
 */
function title_case( $string )
{
    return ucwords( str_replace( '-', ' ', $string ) );
}

/**
 * Format Url
 *
 * Turns /Path To FilEs/ into /path-to-files/
 *
 * @param  string
 * @return string
 */
function format_url( $path )
{
    return strtolower( str_replace( ' ', '-', $path ) );
}

