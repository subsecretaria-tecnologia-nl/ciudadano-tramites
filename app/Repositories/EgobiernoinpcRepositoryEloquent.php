<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernoinpcRepository;
use App\Entities\Egobiernoinpc;
use App\Validators\EgobiernoinpcValidator;

/**
 * Class EgobiernoinpcRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernoinpcRepositoryEloquent extends BaseRepository implements EgobiernoinpcRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernoinpc::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
