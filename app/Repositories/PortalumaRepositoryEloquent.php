<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalumaRepository;
use App\Entities\Portaluma;
use App\Validators\PortalumaValidator;

/**
 * Class PortalumaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalumaRepositoryEloquent extends BaseRepository implements PortalumaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portaluma::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
