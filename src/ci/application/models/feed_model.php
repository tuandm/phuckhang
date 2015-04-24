<?php
/**
 * Feed Model
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */

require_once('land_book_model.php');
class Feed_Model extends Land_Book_Model
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
     * Reference for user' comment
     */
    const REFERENCE_TYPE_COMMENT = 'comment';

    /**
     * Reference for user' comment
     */
    const REFERENCE_TYPE_NOTICE = 'notice';

    /**
     * @var string
     */
    protected $tableName = 'pk_sc_user_feed';

    /**
     * Get newest feeds for displaying to the homepage
     *
     * @return array|bool
     */
    public function getNewFeeds()
    {
        $feeds = $this->db
            ->select()
            ->from($this->tableName)
            ->order_by('feed_id', 'DESC')
            ->limit(10)
            ->get()
            ->result_array();
        return $feeds;
    }

    /**
     * Insert to feed table when new post is posted
     *
     * @param int $userId
     * @param int $referenceId
     * @param string $referenceType
     * @return false|int
     */
    public function insert($userId, $referenceId, $referenceType = self::REFERENCE_TYPE_POST)
    {
        return $this->db->insert(
            $this->tableName,
            array(
                'user_id'           => $userId,
                'reference_id'      => $referenceId,
                'reference_type'    => $referenceType,
                'created_date'      => LandBook_Util::now()
            )
        );
    }
}
