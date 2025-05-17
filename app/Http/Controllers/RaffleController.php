<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\Raffle\StoreRaffleRequest;
use App\Http\Requests\Raffle\UpdateRaffleRequest;
use App\Models\Raffle;
use App\Models\RaffleDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RaffleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Raffle::with(['lottery', 'category'])->paginate(10);
        return ApiResponse::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRaffleRequest $request)
    {
        DB::beginTransaction();

        try {
            // Save the image and get the path
            $imagePath = $request->file('image_file')->store('raffles', 'public');
            // Add the image path to the request data
            $request->merge(['image' => $imagePath]);

            $raffle = Raffle::create($request->all());

            // create numbers for the raffle
            $numbers = $this->generateNumberSeries($request->tickets_number, $request->initial_number);
            $raffleDetails = collect($numbers)->map(function ($number) use ($raffle) {
                return [
                    'number' => $number,
                    'status' => 1,
                    'is_winner' => 0,
                    'raffle_id' => $raffle->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            // insert raffle details by chunks for 1000 records
            $chunks = array_chunk($raffleDetails, 1000);
            foreach ($chunks as $chunk) {
                RaffleDetail::insert($chunk);
            }

            return ApiResponse::success($raffle, 'Rifa creada correctamente', 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponse::error('Error al crear la rifa', 500);
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Raffle $raffle)
    {
        return ApiResponse::success($raffle->load(['lottery', 'category']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRaffleRequest $request, Raffle $raffle)
    {
        if($request->hasFile('image_file')) {
            // remove the image from storage
            if($raffle->image) {
                Storage::disk('public')->delete($raffle->image);
            }

            // Save the image and get the path
            $imagePath = $request->file('image_file')->store('raffles', 'public');
            // Add the image path to the request data
            $request->merge(['image' => $imagePath]);
        }

        $raffle->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image ?? $raffle->image,
            'price' => $request->price,
            'status' => $request->status,
            'end_date' => $request->end_date,
            'sale_type' => $request->sale_type,
            'raffle_category_id' => $request->raffle_category_id,
            'lottery_id' => $request->lottery_id
        ]);

        return ApiResponse::success($raffle, 'Rifa actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Raffle $raffle)
    {
        // check if exists details in status 3
        if($raffle->details()->where('status', 3)->exists()) {
            return ApiResponse::error('No se puede eliminar la rifa porque tiene boletos vendidos', 400);
        }

        // remove the image from storage
        if($raffle->image) {
            Storage::disk('public')->delete($raffle->image);
        }

        $raffle->delete();
        return ApiResponse::success(null, 'Rifa eliminada correctamente');
    }

    /**
     * Generate a sequence of numeric strings starting from a given value.
     *
     * This function returns an array of strings representing numbers from
     * $start up to ($start + $count - 1). It automatically pads each number
     * with leading zeros so that all entries have the same length.
     *
     * @param int $count  Number of values to generate.
     * @param int $start  Starting number for the sequence.
     * @return string[]   Array of zero-padded numeric strings.
     */
    private function generateNumberSeries(int $count, int $start): array
    {
        // Determine the final number in the sequence
        $end = $start + $count - 1;

        // Calculate how many digits the largest number has
        $padLength = strlen((string) $end);

        $result = [];
        for ($i = $start; $i <= $end; $i++) {
            // Convert the integer to a string
            $numStr = (string) $i;

            // If its length is less than the max length, pad with leading zeros
            if (strlen($numStr) < $padLength) {
                $numStr = str_pad($numStr, $padLength, '0', STR_PAD_LEFT);
            }

            $result[] = $numStr;
        }

        return $result;
    }
}
