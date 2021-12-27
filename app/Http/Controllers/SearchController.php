<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class SearchController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel OpenApi Demo Documentation",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
    

     *
     * @OA\Tag(
     *     name="Projects",
     *     description="API Endpoints of Projects"
     * )
     */
    
     /**
     * @OA\Get(
     *      path="/searchByName",
     *      operationId="searchCustomersByName",
     *      tags={"Search"},
     *      summary="Search customer by name",
     *      description="Returns one or list of customers with the same name",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function searchByName(Request $request)
    {
        $search_name = $_GET['query'];

        $customers = DB::table('users')->where('name', 'LIKE', '%' . $search_name . '%')->get();
        return $customers;
    }

      /**
     * @OA\Get(
     *      path="/searchByEmail",
     *      operationId="searchCustomersByEmail",
     *      tags={"Search"},
     *      summary="Search customer by email",
     *      description="Returns customer with same email",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */

    public function searchByEmail(Request $request)
    {
        $search_email = $_GET['query'];
        $customers = DB::table('users')->where('email', 'LIKE', '%' . $search_email . '%')->get();

        return $customers;
    }
      /**
     * @OA\Get(
     *      path="/searchById",
     *      operationId="searchCustomersById",
     *      tags={"Search"},
     *      summary="Search customer by ID",
     *      description="Returns a customer with same ID",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function searchById(Request $request)
    {
        $search_id = $_GET['query'];
        $customers = DB::table('users')->where('id', 'LIKE', '%' . $search_id . '%')->get();

        return $customers;
    }

      /**
     * @OA\Get(
     *      path="/lastday",
     *      operationId="numberOfCustomersRegistered",
     *      tags={"Search"},
     *      summary="Get number of customers registered in the last 24 hours",
     *      description="Returns number of customers registered or added in the last day",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */

    public function lastday()
    {
        $date = Carbon::now();
        $yesterdate = Carbon::yesterday();

        $data = User::whereBetween('created_at', [
            $yesterdate,
            $date,
        ])->count();

        return $data;
    }

      /**
     * @OA\Get(
     *      path="/lastweek",
     *      operationId="numberOfCustomersRegistered",
     *      tags={"Customers"},
     *      summary="Get number of customers registered in the last 7 days",
     *      description="Returns number of customers registered or added and the average in the last week",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */

    public function lastweek()
    {
        $current = Carbon::now();
        $lastWeek = Carbon::now()->subDays(7);

        $result = User::whereBetween('created_at', [
            $lastWeek,
            $current,
        ])->count();

        $average = $result / 7;

        return response()->json([
            'total' => $result,
            'average' => $average
        ]);
    }

      /**
     * @OA\Get(
     *      path="/lastthreemonths",
     *      operationId="numberOfCustomersRegistered",
     *      tags={"Customers"},
     *      summary="Get number of customers registered in the last 90 days",
     *      description="Returns number of customers registered or added and the average in the last three month",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */

    public function lastthreemonths()
    {
        $current = Carbon::now();
        $lastThreeMonths = Carbon::now()->subDays(90);

        $result = User::whereBetween('created_at', [
            $lastThreeMonths,
            $current,
        ])->count();

        $average = $result / 90;

        return response()->json([
            'total' => $result,
            'average' => $average
        ]);
    }

     /**
     * @OA\Get(
     *      path="/lastmonth",
     *      operationId="numberOfCustomersRegistered",
     *      tags={"Customers"},
     *      summary="Get number of customers registered in the last 30 days",
     *      description="Returns number of customers registered or added and the average in the last month",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */

    public function lastmonth()
    {
        $current = Carbon::now();
        $lastMonth = Carbon::now()->subDays(30);

        $result = User::whereBetween('created_at', [
            $lastMonth,
            $current,
        ])->count();

        $average = $result / 30;

        return response()->json([
            'total' => $result,
            'average' => $average
        ]);
    }

     /**
     * @OA\Get(
     *      path="/lastyear",
     *      operationId="numberOfCustomersRegistered",
     *      tags={"Customers"},
     *      summary="Get number of customers registered in the last 365 days",
     *      description="Returns number of customers registered or added and the average in the last year",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function lastyear()
    {
        $current = Carbon::now();
        $lastYear = Carbon::now()->subDays(30);

        $result = User::whereBetween('created_at', [
            $lastYear,
            $current,
        ])->count();

        $average = $result / 365;

        return response()->json([
            'total' => $result,
            'average' => $average
        ]);
    }
}
