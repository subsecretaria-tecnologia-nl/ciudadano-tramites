<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TramitedetalleRepository;
use App\Entities\Tramitedetalle;
use App\Validators\TramitedetalleValidator;

/**
 * Class TramitedetalleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TramitedetalleRepositoryEloquent extends BaseRepository implements TramitedetalleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tramitedetalle::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
