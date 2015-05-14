
<?php

/**
 * Class User_Profile_Model
 */
class User_Profile_Model extends CI_Model
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**
     *
     */
    const INFORMATION_NOT_SET   = 'This information has not been set.';
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
     * @return null|string
     */
    public function getPhoneNumberById($userId)
    {
        $phoneNumber = $this->db
            ->select('pk_cimy_uef_data.VALUE')
            ->from('pk_cimy_uef_data')
            ->join('pk_cimy_uef_fields', 'pk_cimy_uef_fields.ID = pk_cimy_uef_data.FIELD_ID')
            ->where(array(
                'pk_cimy_uef_data.USER_ID'  => $userId,
                'pk_cimy_uef_fields.NAME'   => 'PHONE'
            ))
            ->get()
            ->result_array();
        if (empty($phoneNumber)) {
            return '';
        }
        return $phoneNumber[0]['VALUE'];
    }

    /**
     * Get DOB of user by userId
     *
     * @param int $userId
     * @return string|null
     */
    public function getDOBByUserId($userId)
    {
        $dob = $this->db
            ->select('pk_cimy_uef_data.VALUE')
            ->from('pk_cimy_uef_data')
            ->join('pk_cimy_uef_fields', 'pk_cimy_uef_fields.ID = pk_cimy_uef_data.FIELD_ID')
            ->where(array(
                'pk_cimy_uef_data.USER_ID'  => $userId,
                'pk_cimy_uef_fields.NAME'   => 'DOB'
            ))->get()->result_array();
        if (empty($dob)) {
            return '';
        }
        return $dob[0]['VALUE'];
    }

    /**
     * Get User Title by UserId
     *
     * @param int $userId
     * @return string|array
     */
    public function getTitleByUserId($userId)
    {
        $title = $this->db
            ->select('pk_cimy_uef_data.VALUE')
            ->from('pk_cimy_uef_data')
            ->join('pk_cimy_uef_fields', 'pk_cimy_uef_fields.ID = pk_cimy_uef_data.FIELD_ID')
            ->where(array(
                'pk_cimy_uef_data.USER_ID'  => $userId,
                'pk_cimy_uef_fields.NAME'   => 'TITLE'
            ))
            ->get()->result_array();
        if (empty($title)) {
            return User_Profile_Model::INFORMATION_NOT_SET;
        }
        return $title[0]['VALUE'];
    }

    /**
     * Get User Info by Id
     *
     * @param int $userId
     * @return bool|array
     */
    public function getUserInfoById($userId)
    {
        $userInfo = $this->db
            ->select('pk_users.user_nicename, pk_users.user_email')
            ->from('pk_users')
            ->where(array('ID' => $userId))
            ->get()->result_array();
        if (empty($userInfo)) {
            $userInfo['user_nicename'] = User_Profile_Model::INFORMATION_NOT_SET;
            $userInfo['user_email'] = User_Profile_Model::INFORMATION_NOT_SET;
            return $userInfo;
        }
        return $userInfo[0];
    }

    /**
     * Get user friend list
     *
     * @param int $userId
     * @return array
     */
    public function getFriendsByUserId($userId)
    {
        $where = "((`user_id` = $userId) || (`friend_id` = $userId))";
        $friendRelations = $this->db
            ->select('*')
            ->from('pk_sc_user_friends')
            ->where($where)
            ->get()
            ->result_array();
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
     * @return array|null
     */
    public function getAllUserGroups($userId)
    {
        $groups = $this->db
            ->select('group_id')
            ->from('pk_sc_user_groups')
            ->where('pk_sc_user_groups.user_id', $userId)
            ->get()->result();
        if (empty($groups)) {
            return '';
        }
        return $groups;
    }

}
