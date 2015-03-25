
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
     * Function getUserPhoneById
     *
     * @param string $userId
     * @return string $phoneNumber
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
     * 
     * @param array $userId
     * @return unknown
     */
    public function getDOBByUserId(array $userId)
    {
        $this->db
        ->select('*')
        ->from('pk_cimy_uef_data')
        ->join('pk_cimy_uef_fields', 'pk_cimy_uef_fields.ID = pk_cimy_uef_data.FIELD_ID')
        ->where(array(
                        'pk_cimy_uef_data.USER_ID'  => $userId,
                        'pk_cimy_uef_fields.NAME'   => 'DOB'
        ));
        $dob = $this->db->get()->result_array();
        return $dob;
    }

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
        return $title;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserNameById($userId)
    {
        $this->db->select('pk_users.user_nicename, pk_users.user_email')
        ->from('pk_users')
        ->where(array('ID' => $userId));
        $userInfo = $this->db->get()->result_array()[0];
        return $userInfo;
    }

    /**
     * @param $userId
     * @return array
     */
    public function getFriendsByUserId($userId)
    {
        $where = "((`user_id` = $userId) || (`friend_id` = $userId))";
        $this->db->select('*')
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

    public function countGroupsByUserId($userId)
    {
        $this->db->select('group_id')
        ->from('pk_sc_user_groups')
        ->where(array('user_id' => $userId));
        $numGroups = count($this->db->get()->result_array());
        return $numGroups;
    }

}
?>
