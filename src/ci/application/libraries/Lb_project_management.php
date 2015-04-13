<?php

    /**
     * Library for Project Management class
     * 
     * @author PN
     *
    */
define('PERPAGE', 5);

class Lb_Project_Management extends WP_List_Table
{
    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the
     * class supports AJAX.
     */
    function __construct()
    {
        parent::__construct(array(
            'singular'  => 'lb-proj',
            'plural'    => 'lb-projs',
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
            'col_proj_id'       => __('Project Id'),
            'col_proj_name'     => __('Name'),
            'col_proj_status'   => __('Status')
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
            'col_proj_id'       => array('lb_project_id', false),
            'col_proj_name'     => array('name', false),
            'col_proj_status'   => array('status', false)
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
     * Project Action
     *
     * @param array $item
     * @return string
     */
    function projAction($item)
    {
        $actions = array(
            'edit'      => sprintf('<a href="?page=landbook-projects&proj=%s&act=%s">Edit</a>',
                $item['lb_project_id'], 'edit'),
            'delete'    => sprintf('<a href="?page=landbook-projects&proj=%s&act=%s&amp;noheader=true" onclick="return confirm(\'Do you want to delete %s?\')">Delete</a>'
                , $item['lb_project_id'], 'delete', $item['name'])
        );
        return sprintf('%2s', $this->row_actions($actions));
    }

    /**
     * (non-PHPdoc)
     * @see WP_List_Table::prepare_items()
     */
    function prepare_items($projects, $numProj)
    {
        global $_column_headers;
        $totalPages = ceil($numProj / PERPAGE);
        $this->set_pagination_args(array(
            'total_items'   => $numProj,
            'total_pages'   => $totalPages,
            'per_page'      => PERPAGE
        ));
        $current_page = $this->get_pagenum();
        $this->items = array_slice($projects, (($current_page - 1) * PERPAGE), PERPAGE);
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
        $records = $this->items;
        if (!empty($this->items)) {
            foreach ($records as $rec) {
                echo '<tr ' . $row_class . 'id="record_' . $rec['lb_project_id'] . '">';
                foreach ($columns as $column_name => $column_display_name) {
                    $class = "class='$column_name column_$column_name'";
                    $style = "";
                    if (in_array($column_name, $hidden)) {
                        $style = ' style="display:none;"';
                    }

                    switch ($rec['status']) {
                        case 1: $statusName = 'Sold';
                            break;
                        case 2: $statusName = 'Selling';
                            break;
                        case 3: $statusName = 'Unsold';
                            break;
                        default: $statusName = 'N/A';
                            break;
                    }

                    $attributes = "$class$style";
                    switch ($column_name) {
                        case 'cb':
                            echo '<th scope="row" class="check-column">' . $this->columnCb($rec) . '</th>';
                            break;
                        case 'col_proj_id':
                            echo '<td ' . $attributes . '><strong>'
                                    . stripslashes($rec['lb_project_id']) . '</a></strong>';
                            if (method_exists($this, 'projAction')) {
                                echo call_user_func(array($this, 'projAction'), $rec);
                                echo "</td>";
                            }
                            break;
                        case 'col_proj_name':
                            echo '<td ' . $attributes . '>' . stripslashes($rec['name']) . '</td>';
                            break;
                        case 'col_proj_status':
                            echo '<td ' . $attributes . '>' . stripslashes($statusName) . '</td>';
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
