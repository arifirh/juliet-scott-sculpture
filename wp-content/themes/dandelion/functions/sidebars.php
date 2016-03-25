<?php
/*-------------------- REGISTER SIDEBARS  --------------------*/

if ( !function_exists( 'convert_to_class' ) ) {
	/**
	 * Converts a name that consists of more words and different characters to a class (id).
	 *
	 * @param unknown $name the name to convert
	 */
	function convert_to_class( $name ) {
		return strtolower( str_replace( array( ' ', ',', '.', '"', "'", '/', "\\", '+', '=', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`', '<', '>', '?', '[', ']', '{', '}', '|', ':', ), '', $name ) );
	}
}

if ( !function_exists( 'pexeto_register_sidebar' ) ) {
	/**
	 * Registers a sidebar.
	 *
	 * @param unknown $name the name of the sidebar
	 * @param unknown $id   the id of the sidebar
	 */
	function pexeto_register_sidebar( $name, $id ) {
		register_sidebar( array( 'name'=>$name,
				'id' => $id,
				'before_widget' => '<div class="sidebar-box %2$s" id="%1$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
			) );
	}
}


if ( !function_exists( 'pexeto_register_footer_sidebar' ) ) {
	/**
	 * Registers a footer column sidebar.
	 *
	 * @param unknown $name the name of the sidebar
	 * @param unknown $id   the id of the sidebar
	 */
	function pexeto_register_footer_sidebar( $name, $id ) {
		register_sidebar( array( 'name'=>$name,
				'id' => $id,
				'before_widget' => '<div class="footer-widget %2$s" id="%1$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
			) );
	}
}


if ( !function_exists( 'print_sidebar' ) ) {
	/**
	 * Prints a sidebar.
	 *
	 * @param unknown $name the name of the sidebar to print
	 */
	function print_sidebar( $name ) {
?>
	<div class="sidebar">
    <?php
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( $name ) ) { ?>

    <?php } ?>
</div>
<?php
	}
}


if ( !function_exists( 'print_footer_sidebar' ) ) {
	/**
	 * Prints a footer sidebar column.
	 *
	 * @param unknown $name the name of the sidebar
	 * @param unknown $last if true, then this is the last column
	 */
	function print_footer_sidebar( $name, $last ) {
		$class=$last?'four-columns-4':'four-columns';
?>
	<div class="<?php echo $class; ?>">
    <?php
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( $name ) ) { ?>

    <?php } ?>
</div>
<?php
	}
}


$pexeto_sidebars=array( array( 'name'=>'Default Sidebar', 'id'=>'default' ) );

$pexeto_footer_sidebars=array( array( 'name'=>'Footer First Column', 'id'=>'footer-first' ),
	array( 'name'=>'Footer Second Column', 'id'=>'footer-second' ),
	array( 'name'=>'Footer Third Column', 'id'=>'footer-third' ),
	array( 'name'=>'Footer Fourth Column', 'id'=>'footer-fourth' ) );

$sidebar_strings=get_option( '_sidebar_names' );
$generated_sidebars=explode( $pexeto_separator, $sidebar_strings );
array_pop( $generated_sidebars );
$pexeto_generated_sidebars=array();

//add the generated sidebars to the default ones
foreach ( $generated_sidebars as $sidebar ) {
	$pexeto_sidebars[]=array( 'name'=>$sidebar, 'id'=>convert_to_class( $sidebar ) );
	$pexeto_generated_sidebars[]=array( 'name'=>$sidebar, 'id'=>convert_to_class( $sidebar ) );
}

/**
 * Registers all the sidebars.
 */
if ( function_exists( 'register_sidebar' ) ) {

	//register the sidebars
	foreach ( $pexeto_sidebars as $sidebar ) {
		pexeto_register_sidebar( $sidebar['name'], $sidebar['id'] );
	}

	//register the footer column sidebars
	foreach ( $pexeto_footer_sidebars as $sidebar ) {
		pexeto_register_footer_sidebar( $sidebar['name'], $sidebar['id'] );
	}
}

