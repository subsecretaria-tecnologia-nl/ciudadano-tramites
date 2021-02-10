<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortaltramitecategoriaRepository;
use App\Entities\Portaltramitecategoria;
use App\Validators\PortaltramitecategoriaValidator;

/**
 * Class PortaltramitecategoriaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortaltramitecategoriaRepositoryEloquent extends BaseRepository implements PortaltramitecategoriaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portaltramitecategoria::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
