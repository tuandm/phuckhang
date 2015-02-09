<?php
class CI_SC_Post_Manage extends WP_List_Table {
	/**
	* Constructor, we override the parent to pass our own arguments
	* We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	*/
	function __construct() {
		parent::__construct(array(
			'singular'	=> 'sc-post',
			'plural'	=> 'sc-posts',
			'ajax'		=> true
		));
	}
	
	/**
	* Add extra markup in the toolbars before or after the list
	* @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
	*/
	function extra_tablenav($which) {
		if ($which == 'top') {
			echo "All posts can find here !!!!";
		}
		if ($which == 'bottom') {
			echo "Well Done !!!";
		}
	}
	
	/**
	* Define the columns that are going to be used in the table
	* @return array $columns, the array of columns to use with the table
	*/
	function get_columns() {
		return $columns = array(
				'cb'			=> '<input type="checkbox" />',
				'col_post_id'	=> __('Post Id'),
				'col_post_title'=> __('Title'),
				'col_post_by'	=> __('Author'),
				'col_post_cat'	=> __('Categories'),
				);
	}
	
	/**
	* Decide which columns to activate the sorting functionality on
	* @return array $sortable, the array of columns that can be sorted by the user
	*/
	public function get_sortable_columns() {
		return $sortable = array(
				'col_post_id'		=> array('ID',false),
				'col_post_title'	=> array('post_title',false),
				'col_post_by'		=> array('post_author',false),
				'col_post_cat'		=> array('ID',false)
				);
	}
	
	function get_bulk_actions() {
		$actions = array(
				'delete'	=> 'Delete'
		);
		return $actions;
	}
	function column_cb($item) {
		return sprintf(
			'<input type="checkbox" value="$item->ID" />' 
		);
	}
	
	/**
	* Prepare the table with different parameters, pagination, columns and table elements
	*/
	function prepare_items() {
		global $wpdb, $_column_headers;
		$screen = get_current_screen();
		$orderBy = !empty($_GET["oderby"]) ? $_GET["oderby"] : 'col_post_id';
		$order = !empty($_GET["order"]) ? $_GET["order"] : 'ASC';
		if(!empty($orderBy) & !empty($order)) { 
			$args = array(
				'orderby' => "$orderBy",
				'order'   => "$order",
				'posts_per_page' =>10
			);
			$this->items = new WP_Query($args);
		}
		$totalItems = $this->items->found_posts; 
		$totalPages = ceil($totalItems / 10); 
		$this->set_pagination_args(array(
			"total_items"	=> $totalItems,
			"total_pages"	=> $totalPages,
			"per_page"		=> 10,
		));
		$columns = $this->get_columns();
		$this->_column_headers = array($columns, array(), $this->get_sortable_columns());
	}
	
	/**
	* Display the rows of records in the table
	* @return string, echo the markup of the rows
	*/
	function display_rows() {
		static $row_class = '';
		$row_class = ($row_class == '' ? ' class="alternate"' : '');
		$records = $this->items->posts;
		list($columns, $hidden, $sortableCol) = $this->get_column_info();
		if (!empty($records)) {
			foreach ($records as $rec) {
				echo '<tr ' . $row_class . 'id="record_' . $rec->ID . '">';
				foreach ($columns as $column_name => $column_display_name) {
					$userData = get_userdata($rec->post_author);
					$catName = get_the_category($rec->ID)[0]->cat_name;
					$class = "class='$column_name column-$column_name'";
					$style = "";
					if (in_array($column_name, $hidden)) {
						$style = ' style="display:none;"';
					}
					$attributes = "$class$style";		
					$editScPost = '/wp-admin/post.php?action=edit&post=' . (int) $rec->ID;
					switch ($column_name) {
						case 'cb' : echo '<th scope="row" class="check-column">' . $this->column_cb($rec) . '</th>'; break;
						case 'col_post_id' : echo '<td '.$attributes.'><strong><a href="' . $editScPost . '" title="Edit">' . stripslashes($rec->ID) . '</a></strong></td>'; break;
						case 'col_post_title' : echo '<td ' . $attributes . '>' . stripslashes($rec->post_title) . '</td>'; break;
						case 'col_post_by' : echo '<td ' . $attributes . '>' . stripslashes($userData->user_nicename) . '</td>'; break;
						case 'col_post_cat' : echo '<td ' . $attributes . '>' . stripslashes($catName) . '</td>'; break;
					}
				}
				echo'</tr>';
			}
		}
	}
}