<?php

    /**
     * Library for User Management class
     * 
     * @author PN
     *
    */
define('PERPAGE', 10);

/**
 * @property mixed _column_headers
 */
class Sc_User_Management extends WP_List_Table
{
    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the
     * class supports AJAX.
     */
    function __construct()
    {
        parent::__construct(array(
            'singular'  => 'sc-user',
            'plural'    => 'sc-users',
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
            'col_user_id'       => __('User Id'),
            'col_user_name'     => __('User name'),
            'col_user_email'    => __('User Email'),
            'col_user_group'    => __('Group'),
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
            'col_user_id'       => array('ID', false),
            'col_user_name'     => array('display_name', false),
            'col_user_email'    => array('user_email', false),
        );
    }

    /**
     *
     * @internal param array $item
     * @return string
     */
    function columnCb()
    {
        return sprintf('<input type="checkbox" value="$item->ID" />');
    }

    /**
     * Post Action
     *
     * @param array $item
     * @return string
     */
    function userAction($item)
    {
        $actions = array(
            'editUser' => sprintf('<a href="user-edit.php?user_id=%s">Edit</a>',
                  $item['ID']),
            'editGroup' => sprintf('<a href="?page=%s&act=%s&userId=%s&amp;noheader=true" >Edit Group</a>', 
                filter_input(INPUT_GET, 'page'), 'editGroup', $item['ID']),
            'delete' => sprintf('<a href="?page=%s&act=%s&userId=%s&amp;noheader=true" onclick="return confirm(\'Do you want to delete %s?\')">Delete</a>', 
                filter_input(INPUT_GET, 'page'), 'deleteUser', $item['ID'], $item['user_nicename'])
        );
        return sprintf('%2s', $this->row_actions($actions));
    }

    /**
     * @see WP_List_Table::prepare_items()
     *
     * @param $users
     * @param $numUsers
     */
    function prepare_items($users, $numUsers)
    {
        $totalPages = ceil($numUsers / PERPAGE);
        $this->set_pagination_args(array(
            'total_items'   => $numUsers,
            'total_pages'   => $totalPages,
            'per_page'      => PERPAGE
        ));
        $current_page = $this->get_pagenum();
        $this->items = array_slice($users, (($current_page - 1) * PERPAGE), PERPAGE);
        $columns = $this->get_columns();
        $this->_column_headers = array($columns, array(), $this->get_sortable_columns());
    }

    /**
     *
     * @see WP_List_Table::display_rows()
     * @return string, echo the markup of the rows
     */
 function display_rows()
    {
        /** @var string $row_class */
        static $row_class = '';
        $row_class = ($row_class == '' ? ' class="alternate"' : '');
        list ($columns, $hidden) = $this->get_column_info();
        $records = $this->items;
        if (!empty($this->items)) {
            foreach ($records as $rec) {
                echo '<tr ' . $row_class . 'id="record_' . $rec['ID'] . '">';
                foreach ($columns as $column_name => $column_display_name) {
                    $class = "class='$column_name column_$column_name'";
                    $style = '';
                    if (in_array($column_name, $hidden)) {
                        $style = ' style="display:none;"';
                    }
                    $attributes = "$class$style";
                    switch ($column_name) {
                        case 'cb':
                            echo '<th scope="row" class="check-column">' . $this->columnCb($rec) . '</th>';
                            break;
                        case 'col_user_id':
                            echo '<td ' . $attributes . '><strong>'
                                    . stripslashes($rec['ID']) . '</a></strong>';
                            if (method_exists($this, 'userAction')) {
                                echo call_user_func(array($this, 'userAction'), $rec);
                                echo '</td>';
                            }
                            break;
                        case 'col_user_name':
                            echo '<td ' . $attributes . '>' . stripslashes($rec['user_nicename']) . '</td>';
                            break;
                        case 'col_user_email':
                            echo '<td ' . $attributes . '>' . stripslashes($rec['user_email']) . '</td>';
                            break;
                        case 'col_user_group':
                            echo '<td ' . $attributes . '>';
                            foreach ($rec['group_ids'] as $group) {
                                $groupName = get_term($group['group_id'], 'sc_group');
                                if (empty($groupName)) {
                                    echo "Data is invalid";
                                    continue;
                                }
                                echo '<div class="' . '">';
                                echo "$groupName->name" . str_repeat('&nbsp', 3) 
                                    . sprintf('<a href="?page=%s&act=%s&userId=%s&group=%s&amp&noheader=true"
                                        onclick="return confirm(\'Do you want to delete %s?\')">Delete</a>',
                                        filter_input(INPUT_GET, 'page'), 
                                        'deleteGroup', $rec['ID'], $group['group_id'], $groupName->name);
                                echo '</div>';
                            }
                            echo '</td>';
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
