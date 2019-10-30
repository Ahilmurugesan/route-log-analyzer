<?php

/**
 * Controller for business logic's for the package
 *
 * @author Ahilan
 */

namespace Ahilan\LogViewer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RouteUsageController extends Controller
{

    /**
     * Index function for the package route
     *
     * @return View
     *
     * @author Ahilan
     */
    public function index()
    {
        $query_route = DB::table('route_usages')
                            ->get();

        return view('logViewer::routeusage', compact('query_route'));
    }
}
