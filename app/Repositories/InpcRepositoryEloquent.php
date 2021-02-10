<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InpcRepository;
use App\Entities\Inpc;
use App\Validators\InpcValidator;

/**
 * Class InpcRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class InpcRepositoryEloquent extends BaseRepository implements InpcRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Inpc::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
