<?php

namespace App\Http\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Closure;

class RemovePaginationMeta
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);

            if (isset($data['links'])) {
                unset($data['links']);
            }

            if (isset($data['meta'])) {
                $pagination = $data['meta'];

                if ( isset($pagination['links']) ) {
                    unset($pagination['links']);
                }

                if ( isset($pagination['path']) ) {
                    unset($pagination['path']);
                }

                if ( isset($pagination['per_page']) ) {
                    $pagination['take'] = $pagination['per_page'];
                    unset($pagination['per_page']);
                }
                unset($data['meta']);
                $data['pagination'] = $pagination;
            }

            $response->setData($data);
        }

        return $response;
    }
}
