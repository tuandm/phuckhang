<?php

    /**
     * Library for Post Management class
     * 
     * @author PN
     *
    */
define('PERPAGE', 10);

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
            'singular'  => 'sc-post',
            'plural'    => 'sc-posts',
            'ajax'      => true
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
            'col_post_group'    => __('Groups')
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
            'col_post_id'       => array('ID', false),
            'col_post_title'    => array('post_title', false),
            'col_post_by'       => array('post_author', false),
            'col_post_group'    => array('ID', false)
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
            'edit' => sprintf('<a href="post.php?post=%s&action=%s">Edit</a>',
                  $item->ID, 'edit'),
            'delete' => sprintf('<a href="?page=%s&act=%s&post=%s">Delete</a>', 
                filter_input(INPUT_POST, 'page'), 'delete', $item->ID)
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
        $orderBy = !empty(filter_input(INPUT_GET, 'orderBy')) ? filter_input(INPUT_GET, 'orderBy') : 'col_post_id';
        $order = !empty(filter_input(INPUT_GET, 'order')) ? filter_input(INPUT_GET, 'order') : 'ASC';
        $cat = !empty(filter_input(INPUT_POST, 'cat')) ? filter_input(INPUT_POST, 'cat') : 0;
        $postTitle = !empty(filter_input(INPUT_POST, 's')) ? filter_input(INPUT_POST, 's') : false;
        $groupId = ($cat == 0) ? wp_list_pluck(get_terms('sc_group'), 'term_id') : $cat;
        $args = array(
            'searchTitle'       => $postTitle,
            'post_type'         => 'post',
            'tax_query'         => array(
                                    array(
                                    'taxonomy'  => 'sc_group',
                                    'field'     => 'term_id',
                                    'terms'     => $groupId
                                    )),
            'orderby'           => $orderBy,
            'order'             => $order,
            'posts_per_page'    => PERPAGE
            );
        add_filter('posts_where', array($this, 'titleFilter'), 10, 2);
        $this->items = new WP_Query($args);
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
        list ($columns, $hidden, $sortableCol) = $this->get_column_info();
        $records = $this->items->posts;
        if ($this->items->have_posts()) {
            foreach ($records as $rec) {
                echo '<tr ' . $row_class . 'id="record_' . $rec->ID . '">';
                foreach ($columns as $column_name => $column_display_name) {
                    $userData = get_userdata($rec->post_author);
                    $groupName = wp_get_post_terms($rec->ID, 'sc_group')[0]->name;
                    $class = "class='$column_name column_$column_name'";
                    $style = "";
                    if (in_array($column_name, $hidden)) {
                        $style = ' style="display:none;"';
                    }
                    $attributes = "$class$style";
                    switch ($column_name) {
                        case 'cb':
                            echo '<th scope="row" class="check-column">' . $this->columnCb($rec) . '</th>';
                            break;
                        case 'col_post_id':
                            echo '<td ' . $attributes . '><strong>'
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
                        case 'col_post_group':
                            echo '<td ' . $attributes . '>' . stripslashes($groupName) . '</td>';
                            break;
                    }
                }
                echo '</tr>';
            }
        } else {
            echo '<tr class="no-items"><td class="colspanchange" colspan="' . $this->get_column_count() . '">';
            $this->no_items();
            echo '</td></tr>';
        }
    }
}
