<?php
declare( strict_types = 1 );

spl_autoload_register( function ( string $class ): void
{
    $prefix = 'CTT\\';
	
	
    if( strncmp( $class, $prefix, strlen( $prefix ) ) !== 0 )
	{
		echo "\n", "getting out", "\n";
		echo $class, "\n";
        return;
    }

    $relative = substr( $class, strlen( $prefix ) ); // e.g. Tools\JsonDataLoader
    $path = __DIR__ . DIRECTORY_SEPARATOR
          . str_replace( '\\', DIRECTORY_SEPARATOR, $relative )
          . '.php';
	echo "proceeding", "\n";
	echo $path, "\n";

    if( is_file( $path ) )
	{
        require $path;
    }
} );
?>