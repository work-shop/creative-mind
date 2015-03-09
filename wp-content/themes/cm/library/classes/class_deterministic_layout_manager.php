<?php

class CM_Deterministic_Layout_Manager {

	/**
	 * @var default size
	 */
	public static $default = array('col-sm-3');

	/**
	 * @var array(array(array(string))) determined layout sequences.
	 */
	private static $sequences = array(
		// array(
		// 	array( "col-sm-6" ),
		// 	array( "col-sm-3" ),
		// 	array( "col-sm-3" ),
		// 	array( "col-sm-3" ),
		// 	array( "col-sm-3" ),
		// 	array( "col-sm-6" ),
		// 	array( "col-sm-3" )
		// ),
		array(
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-6" ),
			array( "col-sm-6" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-6" ),
			array( "col-sm-6" )
		),
		array(
			array( "col-sm-6" ),
			array( "col-sm-6" ),
			array( "col-sm-6" ),
			array( "col-sm-6" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-6" ),
			array( "col-sm-6" ),
			array( "col-sm-6" ),
			array( "col-sm-6" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-3" )
		),
		array(
			array( "col-sm-6" ),
			array( "col-sm-6" ),
			array( "col-sm-3" ),
			array( "col-sm-3" ),
			array( "col-sm-6" ),
			array( "col-sm-3", "col-sm-offset-6" ),
			array( "col-sm-3" ),
			array( "col-sm-3", "col-sm-offset-6" ),
			array( "col-sm-3" ),
			array( "col-sm-3", "col-sm-offset-6" ),
			array( "col-sm-3" ),
			array( "col-sm-3", "col-sm-offset-6" ),
			array( "col-sm-3" )
		)
	);

	private static $sequences_sm = array(
			array(
				array( "col-sm-6" ),
				array( "col-sm-6" ),
				array( "col-sm-3" ),
				array( "col-sm-3" )
			)
		);

	private static $limit_sm = 4;

	/**
	 *
	 * @var array(array(string)) the selected sequence for this layout instance.
	 */
	private $selected_sequence;


	/** 
	 * reset the layout manager.
	 * 
	 * @param int $cardinality the number of elements in the set to be layed out.
	 */
	public function reset( $cardinality ) {
		if ( $cardinality <= self::$limit_sm ) {
			$this->selected_sequence = self::$sequences_sm[ rand(0, (count( self::$sequences_sm ) - 1)) ];
		} else {
			$this->selected_sequence = self::$sequences[ rand(0, (count( self::$sequences ) - 1)) ];
		}

		
	}

	/**
	 * Given an index into the set of stories, returns a decision about grid sizing for that story.
	 *
	 * @param int $index the position in the array of stories
	 * @return string a string of bootstrap columns sizes for this story tile.
	 */
	public function layout_tile( $index ) {
		$reduce_set = ( isset( $this->selected_sequence[$index] ) ) 
				? $this->selected_sequence[$index]
				: self::$default;

		return array_reduce(
			$reduce_set,
			function( $y, $x ) { return $x . ' ' . $y; },
			""
		);
	}
}

?>