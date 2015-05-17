<?php
/**
 * Like Model
 * Created by PhpStorm.
 * User: PN
 * Date: 4/1/2015
 * Time: 10:48 PM
 */

require_once('land_book_model.php');
class Like_Model extends Land_Book_Model
{
    /**
     * Reference for user's post
     */
    const REFERENCE_TYPE_POST    = 'post';

    /**
     * Reference for user's status
     */
    const REFERENCE_TYPE_STATUS  = 'status';

    /**
     * @var string
     */
    protected $tableName = 'pk_sc_user_like';

    /**
     * Verify a post/status is whether liked by current user.
     *
     * @param int $userId
     * @param int $referenceId
     * @return array|bool
     */
    public function isLiked($userId, $referenceId)
    {
        $where = array(
            'user_id'       => $userId,
            'reference_id'  => $referenceId
        );
        $isLiked = $this->db
            ->select()
            ->from($this->tableName)
            ->where($where)
            ->get()
            ->result_array();
        return $isLiked;
    }

    /**
     * Insert/remove data to/from pk_sc_user_like when user like/unlike a post/status
     *
     * @param array $likeData
     * @return bool|int
     */
    public function like($likeData)
    {
        $where = array(
            'user_id'           => $likeData['userId'],
            'reference_id'      => $likeData['referenceId'],
            'reference_type'    => $likeData['referenceType'],
        );
        $findLike = $this->db
            ->select()
            ->from($this->tableName)
            ->where($where)
            ->get()
            ->result_array();
        if (empty($findLike)) {
            $result = $this->db->insert($this->tableName, $where);
            if ($result) {
                return $this->db->insert_id();
            }
        } else {
            return $this->db->delete($this->tableName, $where);
        }
    }

    /**
     * Count like number of a post/status
     *
     * @param int $referenceId
     * @return int
     */
    public function countLike($referenceId)
    {
        $where = array('reference_id' => $referenceId);
        $likes = $this->db
                ->select()
                ->from($this->tableName)
                ->where($where)
                ->get()
                ->result_array();
        $numLike = count($likes);
        return $numLike;
    }

    /**
     * Get number of User Likes a post/status by likeId and referenceId
     * @param int $referenceId
     * @return null|array
     */
    function getNumUsersLikeByLikeId($referenceId)
    {
        $where = [
            'reference_id'    => $referenceId,
        ];
        $numUsersLike = $this->db
            ->select('user_nicename')
            ->from($this->tableName)
            ->where($where)
            ->join('pk_users', 'pk_users.ID = ' . $this->tableName . '.user_id')
            ->get()
            ->result_array();
        if (empty($numUsersLike)) {
            return '';
        }
        return $numUsersLike;
    }

}
