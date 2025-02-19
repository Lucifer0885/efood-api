<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->get();

        $response = [
            'status' => true,
            'message' => 'User Addresses',
            'data' => [
              "addresses" => $addresses
            ]
        ];

        return response()->json($response);
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'street' => 'required',
            'number' => '',
            'city' => '',
            'postal_code' => '',
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => '',
            'floor' => '',
            'door' => '',
        ]);

        $address = new Address($request->all());
        $request->user()->addresses()->save($address);

        $response = [
            'status' => true,
            'message' => 'Address created',
        ];

        return response()->json($response, 201);
    }


    public function show(Request $request, $id)
    {
        $address = $request->user()->addresses()->find($id);

        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found'
            ], 404);
        }

        $response = [
            'status' => true,
            'message' => 'Address found successfully',
            'data' => [
              "address" => $address
            ]
        ];

        return response()->json($response);
    }

    public function destroy(Request $request, $id)
    {
        $address = $request->user()->addresses()->find($id);

        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found'
            ], 404);
        }

        $address->delete();

        $response = [
            'status' => true,
            'message' => 'Address deleted successfully',
        ];

        return response()->json($response);
    }
}
