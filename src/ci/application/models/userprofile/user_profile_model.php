
<?php

/**
 * Class User_Profile_Model
 */
class User_Profile_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @var wpdb
     */
    protected $wpdb;

    /**
     * @return wpdb
     */
    public function getWpdb()
    {
        if (!$this->wpdb) {
            global $wpdb;
            $this->wpdb = $wpdb;
        }
        return $this->wpdb;
    }

    /**
     * Function getUserPhoneById
     *
     * @param $userId
     * @return $phoneNumber
     */
    public function getPhoneNumberById($userId)
    {
        $this->db
            ->select('pk_cimy_uef_data.VALUE')
            ->from('pk_cimy_uef_data')
            ->join('pk_cimy_uef_fields', 'pk_cimy_uef_fields.ID = pk_cimy_uef_data.FIELD_ID')
            ->where(array(
                        'pk_cimy_uef_data.USER_ID'  => $userId,
                        'pk_cimy_uef_fields.NAME'   => 'PHONE'
            ));
        $phoneNumber = $this->db->get()->result_array()[0]['VALUE'];
        return $phoneNumber;
    }

    /**
     * Get DOB of user by userId
     *
     * @param int $userId
     * @return array|bool
     */
    public function getDOBByUserId($userId)
    {
        $this->db
        ->select('pk_cimy_uef_data.VALUE')
        ->from('pk_cimy_uef_data')
        ->join('pk_cimy_uef_fields', 'pk_cimy_uef_fields.ID = pk_cimy_uef_data.FIELD_ID')
        ->where(array(
                        'pk_cimy_uef_data.USER_ID'  => $userId,
                        'pk_cimy_uef_fields.NAME'   => 'DOB'
        ));
        $dob = $this->db->get()->result_array();
        return $dob;
    }

    /**
     * Get User Title by UserId
     *
     * @param int $userId
     * @return bool|array
     */
    public function getTitleByUserId($userId)
    {
        $this->db
        ->select('pk_cimy_uef_data.VALUE')
        ->from('pk_cimy_uef_data')
        ->join('pk_cimy_uef_fields', 'pk_cimy_uef_fields.ID = pk_cimy_uef_data.FIELD_ID')
        ->where(array(
            'pk_cimy_uef_data.USER_ID'  => $userId,
            'pk_cimy_uef_fields.NAME'   => 'TITLE'
        ));
        $title = $this->db->get()->result_array()[0]['VALUE'];;
        if ($title) {
            return $title;
        }
        return '';
    }

    /**
     * Get User Info by Id
     *
     * @param int $userId
     * @return bool|array
     */
    public function getUserInfoById($userId)
    {
        $this->db
            ->select('pk_users.user_nicename, pk_users.user_email')
            ->from('pk_users')
            ->where(array('ID' => $userId));
        $userInfo = $this->db->get()->result_array()[0];
        if ($userInfo) {
            return $userInfo;
        }
        return '';
    }

    /**
     * Get user friend list
     *
     * @param int $userId
     * @return array|bool
     */
    public function getFriendsByUserId($userId)
    {
        $where = "((`user_id` = $userId) || (`friend_id` = $userId))";
        $this->db
            ->select('*')
            ->from('pk_sc_user_friends')
            ->where($where);
        $friendRelations = $this->db->get()->result_array();
        $friends = array();
        foreach ($friendRelations as $relation) {
            if ($relation['user_id'] == $userId) {
                $friends[] = $relation['friend_id'];
            } else {
                $friends[] = $relation['user_id'];
            }
        }
        $friends = array_unique($friends);
        $numUserFriends = count($friends);
        $data = array(
                        'friendId'  => $friends,
                        'numFriend' => $numUserFriends 
        );
        return $data;
    }

    /**
     * Get All User Groups by UserId
     *
     * @param int $userId
     * @return array|bool
     */
    public function getAllUserGroups($userId)
    {
        $this->db
            ->select('*')
            ->from('pk_sc_user_groups')
            ->where('pk_sc_user_groups.user_id', $userId);
        $groups = $this->db->get()->result_array();
        $data = array(
            'group'     => $groups,
            'numGroups' => count($groups)
        );
        return $data;
    }

    /**
     * Count all User's Group by UserId
     *
     * @param $userId
     * @return int
     */
    public function countGroupsByUserId($userId)
    {
        $this->db->select('group_id')
        ->from('pk_sc_user_groups')
        ->where(array('user_id' => $userId));
        $groups = count($this->db->get()->result_array());
        $numGroups = count($this->db->get()->result_array());
        $data = array(
            'group'     => $groups,
            'numFriend' => $numGroups
        );
        return $data;
    }
}
