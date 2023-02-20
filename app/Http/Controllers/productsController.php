<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class productsController extends Controller
{
    public function registers(Request $request)
    {
        $fileds = $request->validate([
            'name' =>'required|string',
            'email' =>'required|string|unique:users,email',
            'password' =>'required|string'
        ]);

        $user = User::create(
            [
                'name' =>$fileds['name'],
                'email' =>$fileds['email'],
                'password' =>bcrypt($fileds['password'])
            ]
        );
        $token = $user->createToken('MyApp')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return response($response , 201);
    }

    public function login(Request $request)
    {
        $fileds = $request->validate([
            'email' =>'required|string',
            'password' =>'required|string'
        ]);

        $user = User::where('email' , $fileds['email'])->first();



        if(!$user)
        {
            return response( ["error"=>"No Correct password or email not found"] , 401);
        }

        $token = $user->createToken('MyApp')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return response($response , 201);
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ["msg" =>"logout success"];
    }


    public function index()
    {
        $products = product::all();
        return response()->json($products);
    }

    public function AddProduct(Request $request)
    {
        return  product::create($request->all());
    }

    public function updateProduct($id , Request $request)
    {
        $product = product::find($id);
        $product->update($request->all());
        return $product;
    }

    public function searchProduct($id)
    {
        return product::find($id);
    }



    public function destroyProduct($id)
    {
        return product::destroy($id);
    }
}
