<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortaltramitedivisasRepository;
use App\Entities\Portaltramitedivisas;
use App\Validators\PortaltramitedivisasValidator;

/**
 * Class PortaltramitedivisasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortaltramitedivisasRepositoryEloquent extends BaseRepository implements PortaltramitedivisasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portaltramitedivisas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
