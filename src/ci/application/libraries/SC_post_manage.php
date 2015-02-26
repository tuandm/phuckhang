<?php

    /**
     * Library for Post Management class
     * 
     * @author PN
     *
    */
define("PERPAGE", 10);

class MY_SC_Post_Manage extends WP_List_Table
{
    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the
     * class supports AJAX.
     */
    function __construct()
    {
        parent::__construct(array(
            'singular' => 'sc-post',
            'plural' => 'sc-posts',
            'ajax' => true
        ));
    }

    /**
     * (non-PHPdoc)
     *
     * @see WP_List_Table::get_columns()
     */
    function get_columns()
    {
        return $columns = array(
            'cb'                => '<input type="checkbox" />',
            'col_post_id'       => __('Post Id'),
            'col_post_title'    => __('Title'),
            'col_post_by'       => __('Author'),
            'col_post_cat'      => __('Categories')
            );
    }

    /**
     * (non-PHPdoc)
     *
     * @see WP_List_Table::get_sortable_columns()
     */
    public function get_sortable_columns()
    {
        return $sortable = array(
            'col_post_id' => array('ID', false),
            'col_post_title' => array('post_title', false),
            'col_post_by' => array('post_author', false),
            'col_post_cat' => array('ID', false)
        );
    }

    /**
     *
     * @param array $item            
     * @return string
     */
    function columnCb($item)
    {
        return sprintf('<input type="checkbox" value="$item->ID" />');
    }

    /**
     * Post Action
     *
     * @param array $item
     * @return string
     */
    function postAction($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&act=%s&post=%s">Edit</a>',
                 $_REQUEST['page'], 'edit', $item->ID),
            'delete' => sprintf('<a href="?page=%s&act=%s&post=%s">Delete</a>', 
                $_REQUEST['page'], 'delete', $item->ID)
        );
        return sprintf('%1$s %2$s', $item->col_post_id, $this->row_actions($actions));
    }

    /**
     *
     * @param string $where            
     * @param string $wp_query            
     * @return string
     */
    function titleFilter($where, &$wp_query)
    {
        global $wpdb;
        $searchTerm = $wp_query->get('searchTitle');
        if ($searchTerm) {
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($searchTerm) . '%\'';
        }
        return $where;
    }

    /**
     * (non-PHPdoc)
     *
     * @see WP_List_Table::prepare_items()
     */
    function prepare_items()
    {
        global $wpdb, $_column_headers, $cat;
        $screen = get_current_screen();
        $orderBy = ! empty($_GET['oderBy']) ? $_GET['oderBy'] : 'col_post_id';
        $order = ! empty($_GET['order']) ? $_GET['order'] : 'ASC';
        $cat = ! empty($_POST['cat']) ? $_POST['cat'] : 0;
        $postTitle = ! empty($_REQUEST['s']) ? $_REQUEST['s'] : false;
        if (! empty($orderBy) & ! empty($order)) {
            $args = array(
                'searchTitle'       => $postTitle,
                'cat'               => $cat,
                'orderby'           => $orderBy,
                'order'             => $order,
                'posts_per_page'    => PERPAGE
            );
            add_filter('posts_where', array($this, 'titleFilter'), 10, 2);
            $this->items = new WP_Query($args);
        }
        $totalItems = $this->items->found_posts;
        $totalPages = ceil($totalItems / PERPAGE);
        $this->set_pagination_args(array(
            'total_items'   => $totalItems,
            'total_pages'   => $totalPages,
            'per_page'      => PERPAGE
        ));
        $columns = $this->get_columns();
        $this->_column_headers = array($columns, array(), $this->get_sortable_columns());
    }

    /**
     * (non-PHPdoc)
     *
     * @see WP_List_Table::display_rows()
     * @return string, echo the markup of the rows
     *         Display the rows of records in the table
     */
    function display_rows()
    {
        static $row_class = '';
        $row_class = ($row_class == '' ? ' class="alternate"' : '');
        $records = $this->items->posts;
        list ($columns, $hidden, $sortableCol) = $this->get_column_info();
        if (! empty($records)) {
            foreach ($records as $rec) {
                echo '<tr ' . $row_class . 'id="record_' . $rec->ID . '">';
                foreach ($columns as $column_name => $column_display_name) {
                    $userData = get_userdata($rec->post_author);
                    $catName = get_the_category($rec->ID)[0]->cat_name;
                    $class = "class='$column_name column_$column_name'";
                    $style = "";
                    if (in_array($column_name, $hidden)) {
                        $style = ' style="display:none;"';
                    }
                    $attributes = "$class$style";
                    $editScPost = '/wp-admin/post.php?action=edit&post=' . (int) $rec->ID;
                    switch ($column_name) {
                        case 'cb':
                            echo '<th scope="row" class="check-column">' . $this->columnCb($rec) . '</th>';
                            break;
                        case 'col_post_id':
                            echo '<td ' . $attributes . '><strong>
                                    <a href="' . $editScPost . '" title="Edit">' 
                                    . stripslashes($rec->ID) . '</a></strong>';
                            if (method_exists($this, 'postAction')) {
                                echo call_user_func(array($this, 'postAction'), $rec);
                                echo "</td>";
                            }
                            break;
                        case 'col_post_title':
                            echo '<td ' . $attributes . '>' . stripslashes($rec->post_title) . '</td>';
                            break;
                        case 'col_post_by':
                            echo '<td ' . $attributes . '>' . stripslashes($userData->user_nicename) . '</td>';
                            break;
                        case 'col_post_cat':
                            echo '<td ' . $attributes . '>' . stripslashes($catName) . '</td>';
                            break;
                    }
                }
                echo '</tr>';
            }
        }
    }
}