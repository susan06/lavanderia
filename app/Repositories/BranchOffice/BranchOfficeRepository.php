<?php

namespace App\Repositories\BranchOffice;

use App\BranchOffice;
use App\Repositories\RepositoryInterface;

interface BranchOfficeRepository extends RepositoryInterface
{
    /**
     * Paginate and search
     *
     * return the result paginated for the take value and with the attributes.
     *
     * @param int $take
     * @param string $search
     *
     * @return mixed
     *
     */
    public function paginate_search($take = 10, $search = null, $status = null);

    /**
     *
     * Creates a new location.
     *
     * @param array $attributes
     *
     * @return Model
     *
     */
    public function create_location(array $attributes);

     /**
     *
     * Update the location
     *
     * @param $id
     * @param array $newData
     */
    public function update_location($id, array $newData);

    /**
     *
     * Delete the location
     *
     * @param $id
     * @param array $newData
     */
    public function delete_location($id);

    /**
     *
     * Creates a new service.
     *
     * @param array $attributes
     *
     * @return Model
     *
     */
    public function create_service(array $attributes);

    /**
     *
     * Update the service
     *
     * @param $id
     * @param array $newData
     */
    public function update_service($id, array $newData);

    /**
     *
     * Delete the service
     *
     * @param $id
     * @param array $newData
     */
    public function delete_service($id);

    /**
     * all branch offices in service
     *
     */
    public function all_active();
}