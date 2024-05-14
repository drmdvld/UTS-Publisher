<?php

namespace App\Http\Controllers;

use App\PublisherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://127.0.0.1:8080/api/user');
        $responseData = $response->json();
        $users = $responseData['data'];

        return view('welcome', compact('users'));
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
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $body = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ];

        $dataEncode = json_encode($body);
        $publisher = new PublisherService();
        $publisher->publishCreate($dataEncode);

        return redirect()->back();
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
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $body = [
            'id' => $id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ];
        $dataEncode = json_encode($body);
        $publisher = new PublisherService();
        $publisher->publishUpdate($dataEncode);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try{  
            $body = [
                'id' => $id,
            ];
            $dataEncode = json_encode($body);
            $publisher = new PublisherService();
            $publisher->publishDelete($dataEncode);

            return redirect()->back();

        }catch(\Exception $e){
            return [
                'status' => 400,
                'message' => 'Gagal menghapus user',
                "error" => $e->getMessage(),
            ];
        }
    }
}
