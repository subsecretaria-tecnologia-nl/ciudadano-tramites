<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcamposagrupacionesRepository;
use App\Entities\Portalcamposagrupaciones;
use App\Validators\PortalcamposagrupacionesValidator;

/**
 * Class PortalcamposagrupacionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcamposagrupacionesRepositoryEloquent extends BaseRepository implements PortalcamposagrupacionesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcamposagrupaciones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
