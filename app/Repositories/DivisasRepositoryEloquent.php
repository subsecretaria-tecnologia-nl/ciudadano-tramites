<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DivisasRepository;
use App\Entities\Divisas;
use App\Validators\DivisasValidator;

/**
 * Class DivisasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DivisasRepositoryEloquent extends BaseRepository implements DivisasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Divisas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
