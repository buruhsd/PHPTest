<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::when($request->has('q'), function ($query) use ($request) {
            $query->where('name','LIKE','%'.$request->q.'%')->orWhere('name','LIKE','%'.$request->q.'%');
        })
        ->when($request->has('ob') && $request->has('sb'), function ($query) use ($request) {
            $query->orderBy($request->ob, $request->sb);
        })
        ->when($request->has('of') && $request->has('lt'), function ($query) use ($request) {
            $query->skip($request->of);
            $query->limit($request->lt);
        })->get();
        return response()->json($data);
    }

    // if (!function_exists('sessionProperty')) {
    //     function sessionProperty()
    //     {
    //         return Request::header("Property-Selected") ? Auth::user()->property()->find(Request::header("Property-Selected")) : null;
    //     }
    //   }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'  => 'string|required',
            'address' => 'string|required',
            'email' => 'email|required|unique:users',
            'password' => 'string|required',
            'photos' => 'array|required',
            'photos.*.file' => 'mimes:jpeg,jpg,png|required',
            'creditcard_type' => 'string|required',
            'creditcard_number' => 'string|required',
            'creditcard_name' => 'string|required',
            'creditcard_expired' => 'string|required',
            'creditcard_cvv' => 'string|required',
        ],
        [
            'creditcard_type.required' => 'Credit card data invalid.',
            'creditcard_number.required' => 'Credit card data invalid.',
            'creditcard_name.required' => 'Credit card data invalid.',
            'creditcard_expired.required' => 'Credit card data invalid.',
            'creditcard_cvv.required' => 'Credit card data invalid.',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }

        $input = $request->except(['photos']);
        $input['password'] = Hash::make($request->password);
        $user = User::create($request->all());
        $user->creditcard()->create($input);

        if(isset($request->photos) && count($request->photos) > 0){
            foreach($request->photos as $photos){
                $image = storeImages('public/images/photos/'.$user->id.'/', $photos['file']);
                $urlImage = Storage::url('public/images/photos/'.$user->id.'/'. $image);
                $user->photos()->create([
                    'url' => $urlImage
                ]);
            }
        }


        return response()->json(['user_id' => $user->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        $data['photos'] = $data->photos;
        $data['creditcard'] = $data->creditcard;

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'numeric|required',
            'name'  => 'string',
            'address' => 'string',
            'email' => 'email',
            'password' => 'string',
            'photos' => 'array',
            'photos.*.file' => 'mimes:jpeg,jpg,png',
            'creditcard_type' => 'string',
            'creditcard_number' => 'string',
            'creditcard_name' => 'string',
            'creditcard_expired' => 'string',
            'creditcard_cvv' => 'string',
        ],
        [
            'creditcard_type.string' => 'Credit card data invalid.',
            'creditcard_number.string' => 'Credit card data invalid.',
            'creditcard_name.string' => 'Credit card data invalid.',
            'creditcard_expired.string' => 'Credit card data invalid.',
            'creditcard_cvv.string' => 'Credit card data invalid.',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }

        $input = $request->except(['photos', 'user_id']);
        $input['password'] = Hash::make($request->password);
        $user = User::findOrFail($request->user_id);
        $user->update($input);
        $user->creditcard()->first()->update($input);

        return response()->json(['user_id' => $user->id]);
    }

}
