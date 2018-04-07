<?php
/**
 * GetUserRequestBuilder.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Requestors\User;


interface IGetUserRequestBuilder
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
     * @return IGetUserRequest
     */
    public function build();

}