<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wolt;
use Illuminate\Support\Facades\Http;

class WoltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function authorization(Request $request){

        $headerKey = $request->header('X-API-Key');

        if (!$headerKey || $headerKey !== env('WOLT')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'missing X-API-Key',
            ], 401); // 401 Unauthorized
        }

        $data=$request->all();
        try{
            $request=Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-API-Key'=>$headerKey])
                ->withBody(json_encode($data))
                ->post("http://213.230.99.65:8080/api/wolt/authorize");
            if($request->successful()){
                switch($request->status()){
                    case 200:
                        return response()->json(["status"=>"success"],200);    
                    break;
                    case 401:
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'missing X-API-Key',
                        ], 401); // 401 Unauthorized
                    break;
                    case 500:
                        return response()->json(["status"=>"error"],500);    
                    break;
                    default:
                        return response()->json(["status"=>"error"],500);
                    break;
                }

            }

            return response()->json(["status"=>"success"],200);

        }catch(\Exception $e){
            return response()->json(["status"=>"error"],500);

        }

    }
}
