<?php


class CM_Tile_Layout_Manager {

	/**
	 * @var int $gridrows the number of row available for layout
	 */
	public static $gridrows = 4;

	/**
	 * @var int $gridcols the number of columns available for layout
	 */
	public static $gridcols = 4;

	/**
	 * @var maps sizes into the number of rows and columns that size occupies in the grid,
	 *       as well as the maximum number of elements of that size allowed in the grid.
	 */
	public static $sizing = array(
		"large" => array(
			"rows" => 2, 
			"cols" => 2, 
			"max" => 1, 
			"classes" => array( "col-sm-6" )
		),
		"small" => array(
			"rows" => 1, 
			"cols" => 1, 
			"max" => INF, 
			"classes" => array( "col-sm-3" )
		)
	);

	public static $offsetmap = array(
		"", "col-sm-offset-3", "col-sm-offset-6"
	);

	/**
	 * @var array the set of defaults if we have exceeded our choices
	 */
	private static $defaults = array(
		'small'
	);

	/**
	 * @var int the number of elements we are traversing
	 */
	public $number;

	/**
	 * @var map(int=>string) the set of past layout decisions
	 */
	private $history;

	/**
	 * @var map(string=>int) map of sizes to counts for that size
	 */
	private $counts;

	/**
	 * @var int the number of available columns in the row, accounting for dead space
	 */
	private $current_gridcols;

	/**
	 * @var int the current alignment offset for initial rows.
	 */
	private $current_offset_multiplier;

	/**
	 * @var int current index into the set of rows.
	 */
	private $current_row;

	/**
	 * @var map(int => int) memoized row data.
	 */
	private $rows;

	/** 
	 * reset the layout manager.
	 * 
	 * @param int $cardinality the number of elements in the set to be layed out.
	 */
	public function reset( $cardinality ) {

		$this->number 			= $cardinality; // the total number of elements in this grid
		$this->history 			= array(); // the history of size assignments in this grid
		$this->counts 			= array(); // the number of each size currently in the grid
		$this->rows 			= array( self::$gridcols );

		$this->current_gridcols		= self::$gridcols; // the number of available columns in the current grid row
		$this->current_offset 		= 0; // the current offset across the grid. (appended if the gridded element is row-initial)
		$this->current_row 		= 0;

		foreach ( array_keys( self::$sizing ) as $key ) {
			$this->counts[ $key ] = 0; // initialize counts to 0, set sizing keys;
		}
	}

	/**
	 * Given an index into the set of stories, returns a decision about grid sizing for that story.
	 *
	 * @param int $index the position in the array of stories
	 * @return string a string of bootstrap columns sizes for this story tile.
	 */
	public function layout_tile( $index ) {

		if ( empty( $this->history ) ) {
			/*
				The layout history is empty, we can make an arbitrary choice.
			 */
			return $this->update( $this->arbitrary_choice() );
		} else {
			/*
				The history is populated. We need to divide it up into rows, to see what our available
				Choices are. We are trying to ascertain how much room is remaining in the row. The
				remaining space on the row will tell us what valid choices are.
			 */
			return $this->update( $this->choice( ) );
		}
		
	}

	/**
	 * records a choice in the sizing history, manages additional state
	 *
	 * @param string $choice the choice of size, must be a valid size key.
	 */
	private function update( $choice ) {
		array_push( $this->history, $choice );
		$this->counts[ $choice ] += 1;

		/* 
			[1] first, let's append the specified offset if we're on the initial index in the row.
		*/

		// echo "current offset:\n";
		// var_dump( $this->current_offset );

		// echo "current row:\n";
		// var_dump( $this->current_row );

		// var_dump( $this->rows );
		// var_dump( self::$offsetmap );

		$offset = ( $this->rows[ $this->current_row ] == $this->current_gridcols )
			  ? self::$offsetmap[ $this->current_offset ] : ""; // if we're at the beginning 

		/* 
			[2] now, let's decrement the current row by the width of our choice,
			     taking not of the amount of previously used space.
		*/
		$this->current_gridcols = (self::$sizing[ $choice ]['rows'] > 1) ? $this->rows[ $this->current_row ] : $this->current_gridcols; // the available space
		$this->rows[ $this->current_row ] -= self::$sizing[ $choice ]['cols'];


		/* 
			[3] now we need to compute the imapact of our choice on subsequent rows.
			[3.1] for every unit multiple of rows on the choice, we need to subtract that much from
				from the available row-space.
			[3.2] then, we need to translate the available space down.
		*/
		for ( $i = 1; $i < self::$sizing[ $choice ]['rows']; $i++ ) {

			if ( !isset( $this->row[ $this->current_row + $i ] ) ) { 

				$this->data[ $this->current_row + $i ] = $this->current_gridcols - self::$sizing[ $choice ]['cols']; 

			} else {

				$row_data[ $this->current_row + $i ] -= self::$sizing[ $choice ]['cols'];
			}

		}

		/* 
			[4] if we've hit 0 available space on the current row, we need to move on to the next row.
		*/

		if ( $this->rows[ $this->current_row ] == 0 ) { $this->current_row += 1; }

		/* 
			[5] if the new row doesn't have any value, we need to plug in a new default;
		*/
		if ( !isset( $this->rows[$this->current_row] ) ) { $this->rows[$this->current_row] = $this->current_gridcols; }

		/* 
			[6] we need to update the current offset based on what we've just computed.
		*/
		$this->current_offset = self::$gridcols - $this->current_gridcols;

		return array_reduce( 
			self::$sizing[ $choice ]['classes'], 
			function( $x, $y ) { return $y . ' ' . $x; },
			$offset
		);
	}

	// /**
	//  * calculates the remaining space in the row, by summing over the history proportionally.
	//  * We need to keep track of constraint information in two dimensions, remember.
	//  *
	//  * @return int number of remaining columns in the row.
	//  */
	// private function calculate_remaining_space() {
	// 	/*
	// 		We'll store our constraint information in an array in which
	// 		the first subscript will represent the row index and the second will represent 
	// 		the remaining space on that column. "We can optimize this by keeping track of
	// 		the summation as we go, as well. To do this, we'll have to maintain a pointer
	// 		into the history index, which will indicate where we currently are." 
	// 	 */

	// 	$row_data = array( $this->current_gridcols ); // to start, there are current-gridcols in the row
	// 	$current_row = 0; // and we are currently on the first row.

	// 	foreach ( $this->history as $size ) {
	// 		if ( !isset( $row_data[ $current_row ] ) ) { $row_data[$current_row] = self::$gridcols; }
	// 		$row_data[ $current_row ] -= self::$sizing[ $size ]['cols'];

	// 		for ( $i = 1; $i < self::$sizing[ $size ]['rows']; $i++ ) {
	// 			if ( !isset( $row_data[ $current_row + $i ] ) ) { 
	// 				$row_data[ $current_row + $i ] = self::$gridcols - self::$sizing[ $size ]['cols']; 
	// 			} else {
	// 				$row_data[ $current_row + $i ] -= self::$sizing[ $size ]['cols'];
	// 			}

	// 		}

	// 		if ( $row_data[ $current_row ] == 0 ) { $current_row += 1; }
	// 	}

	// 	if ( !isset( $row_data[ $current_row ] ) ) { $row_data[ $current_row ] = self::$gridcols; }

	// 	/*
	// 		Once we've finished, we just need to return the number of available columns in the current row.
	// 	*/

	// 	return $row_data[ $current_row ];
	// }

	/**
	 * make a choice based on the remaining number of columns in the current row
	 *
	 * @return string a valid choice from among the available sizes.
	 */
	private function choice(  ) {
		$choices = array();
		$remaining_columns = $this->rows[ $this->current_row ];

		foreach ( self::$sizing as $size => $sizedata ) {
			if ( 
				$sizedata['cols'] <= $remaining_columns
			   && $sizedata['max'] > $this->counts[ $size ] 
			){
				array_push( $choices, $size );
			}
		}

		return $choices[ rand(0, (count($choices) - 1) ) ];
	}

	/**
	 * make an arbitrary choice from amoung the available options.
	 *
	 * @return string a valid choice from amoung the available sizes.
	 */
	private function arbitrary_choice() {
		$choices = array_keys( self::$sizing );
		return $choices[ rand(0, count( $choices ) - 1 ) ];
	}

}


?>