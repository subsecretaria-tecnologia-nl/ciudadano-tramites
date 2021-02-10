<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcampoRepository;
use App\Entities\Portalcampo;
use App\Validators\PortalcampoValidator;

/**
 * Class PortalcampoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcampoRepositoryEloquent extends BaseRepository implements PortalcampoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcampo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
