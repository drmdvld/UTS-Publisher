<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\PublisherService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $response = Http::get('http://127.0.0.1:8080/api/user');
            $responseData = $response->json();
            $users = $responseData['data'];

            return [
                'status' => 200,
                'message' => 'berhasil mendapatkan semua user',
                'data' => $users
            ];
        }catch(\Exception $e){
            return [
                'status' => 400,
                'message' => 'gagal mendapatkan semua user',
                'error' => $e->getMessage()
            ];
        }
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
        try{
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

            return [
                'status' => 200,
                'message' => 'berhasil menambahkan user',
                'data' => $body
            ];
        }
        catch(\Exception $e){
            return [
                'status' => 400,
                'message' => 'Gagal menambahkan user',
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $response  = Http::get("http://127.0.0.1:8080/api/user/$id");
            $responseData = $response->json();
            $user = $responseData['data'];

            return [
                'status' => 200,
                'message' => 'berhasil menambahkan user',
                'data' => $user
            ];
        }
        catch(\Exception $e){
            return [
                'status' => 400,
                'message' => 'Gagal menambahkan user',
                'data' => $e->getMessage()
            ];
        }
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
        try{
            $request->validate([
                'name' => 'required|string',
                'username' => 'required|string',
                'email' => 'required|string',
            ]);

            $body = [
                'id' => $id,
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ];

            $dataEncode = json_encode($body);
            $publisher = new PublisherService();
            $publisher->publishUpdate($dataEncode);

            return [
                'status' => 200,
                'message' => 'berhasil mengubah user',
                'data' => $body
            ];
        }
        catch(\Exception $e){
            return [
                'status' => 400,
                'message' => 'Gagal mengubah user',
                'data' => $e->getMessage()
            ];
        }
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

            return [
                'status' => 200,
                'message' => 'berhasil menghapus user',
                "data" => "user dengan id $id berhasil dihapus"
            ];
        }catch(\Exception $e){
            return [
                'status' => 400,
                'message' => 'Gagal menghapus user',
                "error" => $e->getMessage(),
            ];
        }
    }
}
