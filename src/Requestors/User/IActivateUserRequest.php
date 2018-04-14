<?php
/**
 * IActivateUserRequest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Requestors\User;

interface IActivateUserRequest
{
    /**
     * @param $id
     *
     * @return IActivateUserRequest
     */
    public function withUserId($id);

    /**
     * @return mixed
     */
    public function getUserId();
}