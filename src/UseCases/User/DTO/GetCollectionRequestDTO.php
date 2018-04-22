<?php
/**
 * GetCollectionRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\User\IGetCollectionRequest;

/**
 * Class GetCollectionRequestDTO
 */
class GetCollectionRequestDTO extends CollectionRequest implements IGetCollectionRequest
{
    public $userName;
    public $eMail;
    public $enabled;
    public $token;
    public $firstName;
    public $lastName;

    /**
     * @param Comparison $comparison
     *
     * @return $this
     */
    public function withUserName(Comparison $comparison = null)
    {

        $this->useComparison('userName', $comparison);

        return $this;
    }

    public function withEMail(Comparison $comparison = null)
    {
        $this->useComparison('eMail', $comparison);

        return $this;
    }

    public function withAccess(Comparison $comparison = null)
    {
        $this->useComparison('enabled', $comparison);

        return $this;
    }

    public function withToken(Comparison $comparison = null)
    {
        $this->useComparison('token', $comparison);

        return $this;
    }

    public function withFirstName(Comparison $comparison = null)
    {
        $this->useComparison('firstName', $comparison);

        return $this;
    }

    public function withLastName(Comparison $comparison = null)
    {
        $this->useComparison('lastName', $comparison);

        return $this;
    }




}