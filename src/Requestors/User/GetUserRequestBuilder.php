<?php
/**
 * GetUserRequestBuilder.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Requestors\User;


interface GetUserRequestBuilder
{
    /**
     * @return $this
     */
    public function create();

    /**
     * @param $userId
     *
     * @return $this
     */
    public function withUserId($userId);

    /**
     * @return GetUserRequest
     */
    public function build();

}