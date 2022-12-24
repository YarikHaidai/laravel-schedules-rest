<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Services\Log\LogService;
use App\Services\Telegram\Commands\Payments\PaymentCommand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return array|Collection
     */
    public function all(): array|Collection
    {
        return $this->model->all();
    }

    /**
     * @param string $id
     * @return Model
     */
    public function find(string $id): Model
    {
        $object = $this->model->find($id);

        if (!($object instanceof $this->model)) {
            throw new NotFoundHttpException();
        }

        return $object;
    }

    /**
     * @param string $id
     * @return Model
     */
    public function findLock(string $id): Model
    {
        $object = $this->model->lockForUpdate()->find($id);

        if (!($object instanceof $this->model)) {
            throw new NotFoundHttpException();
        }

        return $object;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function findOne(array $attributes): mixed
    {
        return $this->model->where($attributes)->first();
    }

    /**
     * @param array $attributes
     * @param array $updateData
     * @return mixed
     */
    public function updateOne(array $attributes, array $updateData): mixed
    {
        return $this->model
            ->where($attributes)
            ->first()
            ->update($updateData);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $model = $this->model->create($attributes);
        $model->refresh();

        return $model;
    }

    /**
     * @param Request $request
     * @param array $except
     * @return Model
     */
    public function make(Request $request, array $except = []): Model
    {
        if ($request->has('id')) {
            return $this->model
                ->find($request->get('id'))
                ->fill($request->except($except));
        }

        return $this->model::make($request->except($except));
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function store(Model $model): bool
    {
        return $model->getKey() ? $this->update($model) : $this->save($model);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function save(Model $model): bool
    {
        $status = $model->save();
        $model->refresh();

        return $status;
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function update(Model $model): bool
    {
        if (empty($model->getOriginal())) {
            $freshValues = $model->getAttributes();
            $model->exists = true;
            $model->refresh()->fill($freshValues);
        }

        $status = $model->update();

        if (!$status) {
            LogService::system('BaseRepository::update', [
                'message' => sprintf("Model %s, id: %s", $model::class, $model->id)
            ]);
        }

        return $status;
    }

    /**
     * @param Model $model
     * @param array $attributes
     * @return bool
     */
    public function updateAttributes(Model $model, array $attributes): bool
    {
        $model->fill($attributes);

        return $this->update($model);
    }

    /**
     * @param Model $model
     * @param array $attributes
     * @return bool
     */
    public function saveQuietly(Model $model, array $attributes): bool
    {
        $model->fill($attributes);

        return $model->saveQuietly();
    }

    /**
     * @param array $ids
     * @param array $attributes
     * @return mixed
     */
    public function bulkUpdate(array $ids, array $attributes): mixed
    {
        foreach ($ids as $id) {
            $object = $this->model->find($id);
            if ( $object instanceof $this->model ) {
                $object->update($attributes);
            }
        }

        return $this->model
            ->whereIn('id', $ids)
            ->get();
    }

    /**
     * @param array $ids
     * @return bool|int|null
     */
    public function bulkDestroy(array $ids): bool|int|null
    {
        return $this->model
            ->whereIn('id', $ids)
            ->delete();
    }
}
