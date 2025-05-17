<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\Lottery\StoreLotteryRequest;
use App\Http\Requests\Lottery\UpdateLotteryRequest;
use App\Models\Lottery;
use Illuminate\Support\Facades\Storage;

class LotteryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Lottery::paginate(10);
        return ApiResponse::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLotteryRequest $request)
    {
        // Save the image and get the path
        $imagePath = $request->file('image_file')->store('lotteries', 'public');
        // Add the image path to the request data
        $request->merge(['image' => $imagePath]);

        $item = Lottery::create($request->all());
        return ApiResponse::success($item, 'Lotería creada correctamente', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lottery $lottery)
    {
        return ApiResponse::success($lottery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLotteryRequest $request, Lottery $lottery)
    {
        if($request->hasFile('image_file')) {
            // remove the image from storage
            if ($lottery->image) {
                Storage::disk('public')->delete($lottery->image);
            }

            // Save the image and get the path
            $imagePath = $request->file('image_file')->store('lotteries', 'public');
            // Add the image path to the request data
            $request->merge(['image' => $imagePath]);
        }

        $lottery->update($request->all());
        return ApiResponse::success($lottery, 'Lotería actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lottery $lottery)
    {
        // remove the image from storage
        if ($lottery->image) {
            Storage::disk('public')->delete($lottery->image);
        }

        $lottery->delete();
        return ApiResponse::success(null, 'Lotería eliminada correctamente');
    }
}
