<?php

namespace Ahilan\LogViewer\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteUsageMiddleware
{
    /**
     * Route usage middle to access for every request
     *
     * @param  Request  $request
     *
     * @return string
     */
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->path();
        $route_param = $request->route()->getAction();
        $name = isset($route_param['as']) ? $route_param['as'] : null;
        $action = isset($route_param['controller']) ?
                    $route_param['controller'] : null;
        $prefix = isset($route_param['prefix']) ? $route_param['prefix'] : null;
        $query_result = DB::table('route_usages')
            ->where(function($query) use($name, $action, $prefix, $uri){
                if($prefix !== null){
                    $uri = $prefix.'/'.$uri;
                }
                $query->where('route_name', $name)
                    ->Where('controller', $action)
                    ->Where('uri', $uri);
            })
            ->first();
        if(! empty($query_result))
        {
            $final_count = $query_result->count + 1;
            DB::table('route_usages')
                ->where(function($query) use($name, $action, $prefix, $uri){
                    if($prefix !== null){
                        $uri = $prefix.'/'.$uri;
                    }
                    $query->where('route_name', $name)
                        ->Where('controller', $action)
                        ->Where('uri', $uri);
                })
                ->update([
                    'count' => $final_count,
                    'last_accessed' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }else{
            DB::table('route_usages')
                ->Insert([
                    'route_name' => isset($name) ?
                        $name : null,
                    'uri' => isset($uri) ?
                        $uri : null,
                    'controller' => isset($action) ?
                        $action : null,
                    'prefix' => isset($prefix) ?
                        $prefix : null,
                    'count' => 1,
                    'last_accessed' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }

        return $next($request);
    }
}
