<?php


namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class AbstractStoreRequest extends Request
{
    /**
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function rules(): array
    {
        if (request()->has('id')) {
            return $this->updateRules(request()->get('id'));
        }

        return $this->createRules();
    }

    /**
     * @return array
     */
    public function createRules(): array
    {
        $rules = [];
        $required = $this->required();
        $unique = $this->unique();

        foreach ($this->basicRules() as $key => $rule) {
            if (in_array($key, $required)) {
                $rule[] = 'required';
            }
            if (in_array($key, array_keys($unique))) {
                $rule[] = 'unique:' . $unique[$key]['table'] . ',' . $unique[$key]['field'];
            }
            $rules[$key] = $rule;
        }

        return $rules;
    }

    /**
     * @param null $id
     * @return array
     */
    public function updateRules($id = null): array
    {
        if (is_null($id)) {
            return $this->basicRules();
        }

        $rules = [];
        $unique = $this->unique();
        $required = $this->required();

        foreach ($this->basicRules() as $key => $rule) {
            if (in_array($key, $required)) {
                $rule[] = 'required';
            }

            if (in_array($key, array_keys($unique))) {
                $rule[] = Rule::unique($unique[$key]['table'])->ignore($id);
            }
            $rules[$key] = $rule;
        }

        return $rules;
    }

    protected function required(): array
    {
        return [];
    }

    protected function unique(): array
    {
        return [];
    }

    abstract protected function basicRules(): array;
}
