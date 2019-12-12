<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Utils;

class SettingsController extends Controller
{
    public function updateAddress(Request $request)
    {
        $this->validate($request, [
            'address' => 'required|string|max:255',
        ]);

        $data = ['address' => $request->address];

        $coordinates = Utils::getCoordinatesFromAddress($request->address);
        if($coordinates){
            $data['lat'] = $coordinates[0];
            $data['lon'] = $coordinates[1];
            $data['coordinates'] = Utils::getPointFromCoordinates($coordinates);
        }

        $request->user()->forceFill($data)->save();
    }
}
