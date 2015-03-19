<?php

    /**
     * Library for Product Management class
     * 
     * @author PN
     *
    */
define('PERPAGE', 10);

class MY_LBProductManage extends WP_List_Table
{
    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the
     * class supports AJAX.
     */
    function __construct()
    {
        parent::__construct(array(
            'singular'  => 'lb-poduct',
            'plural'    => 'lb-products',
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
            'col_proc_code'     => __('Product Code'),
            'col_proc_price'    => __('Price'),
            'col_proc_status'   => __('Status'),
            'col_proc_proj'     => __('Project')
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
            'col_proc_code'         => array('code', false),
            'col_proc_price'        => array('price', false),
            'col_proc_status'       => array('status', false),
            'col_proc_proj'         => array('lb_project_id', false)
        );
    }

    /**
     *
     * @param array $item
     * @return string
     */
    function columnCb($item)
    {
        return sprintf('<input type="checkbox" value="$item->code" />');
    }

    /**
     * Project Action
     *
     * @param array $item
     * @return string
     */
    function productAction($item)
    {
        $actions = array(
            'edit'      => sprintf('<a href="?page=landbook-products&proc=%s&act=%s">Edit</a>',
                $item['lb_product_id'], 'edit'),
            'delete'    => sprintf('<a href="?page=landbook-products&proc=%s&act=%s&amp;noheader=true">Delete</a>',
                $item['lb_product_id'], 'delete')
        );
        return sprintf('%2s', $this->row_actions($actions));
    }

    /**
     * (non-PHPdoc)
     * @see WP_List_Table::prepare_items()
     */
    function prepare_items($products, $numProc)
    {
        global $wpdb, $_column_headers;
        $totalPages = ceil($numProc / PERPAGE);
        $this->set_pagination_args(array(
            'total_items'   => $numProc,
            'total_pages'   => $totalPages,
            'per_page'      => PERPAGE
        ));
        $this->items = $products;
        foreach ($this->items as &$item) {
            $item['name'] = $wpdb->get_col('SELECT name FROM pk_lb_projects WHERE lb_project_id =' . $item['lb_project_id'])[0];
        }
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
                echo '<tr ' . $row_class . 'id="record_' . $rec['code'] . '">';
                foreach ($columns as $column_name => $column_display_name) {
                    $class = "class='$column_name column_$column_name'";
                    $style = "";
                    if (in_array($column_name, $hidden)) {
                        $style = ' style="display:none;"';
                    }
                    switch ($rec['status']) {
                        case 1: $statusName = 'Đặt Cọc';
                            break;
                        case 2: $statusName = 'Đã Bán';
                            break;
                        case 3: $statusName = 'Chưa Bán';
                            break;
                    }
                    $attributes = "$class$style";
                    switch ($column_name) {
                        case 'cb':
                            echo '<th scope="row" class="check-column">' . $this->columnCb($rec) . '</th>';
                            break;
                        case 'col_proc_code':
                            echo '<td ' . $attributes . '><strong>'
                                    . stripslashes($rec['code']) . '</a></strong>';
                            if (method_exists($this, 'productAction')) {
                                echo call_user_func(array($this, 'productAction'), $rec);
                                echo "</td>";
                            }
                            break;
                        case 'col_proc_price':
                            echo '<td ' . $attributes . '>' . stripslashes($rec['price']) . '</td>';
                            break;
                        case 'col_proc_status':
                            echo '<td ' . $attributes . '>' . stripslashes($statusName) . '</td>';
                            break;
                        case 'col_proc_proj':
                            echo '<td ' . $attributes . '>' . stripslashes($rec['name']) . '</td>';
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
