<?php

namespace App\Http\Controllers\BuildingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\MeterReading;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    public function index($flatId)
    {
        $flat = Flat::findOrFail($flatId);
        $meterReadings = $flat->meterReadings()->orderByDesc('reading_date')->get();
        return view('building-admin.meter_readings.index', compact('flat', 'meterReadings'));
    }

    public function create($flatId)
    {
        $flat = Flat::findOrFail($flatId);
        return view('building-admin.meter_readings.create', compact('flat'));
    }

    public function store(Request $request, $flatId)
    {
        $request->validate([
            'reading_date' => 'required|date',
            'reading_value' => 'required|numeric',
            'unit' => 'required',
            'type' => 'required',
        ]);
        MeterReading::create([
            'flat_id' => $flatId,
            'reading_date' => $request->reading_date,
            'reading_value' => $request->reading_value,
            'unit' => $request->unit,
            'type' => $request->type,
        ]);
        return redirect()->route('building-admin.meter_readings.index', $flatId)->with('success', 'Meter reading added successfully.');
    }

    public function edit($flatId, $id)
    {
        $flat = Flat::findOrFail($flatId);
        $meterReading = MeterReading::findOrFail($id);
        return view('building-admin.meter_readings.edit', compact('flat', 'meterReading'));
    }

    public function update(Request $request, $flatId, $id)
    {
        $meterReading = MeterReading::findOrFail($id);
        $meterReading->update($request->only(['reading_date', 'reading_value', 'unit', 'type']));
        return redirect()->route('building-admin.meter_readings.index', $flatId)->with('success', 'Meter reading updated successfully.');
    }

    public function destroy($flatId, $id)
    {
        MeterReading::findOrFail($id)->delete();
        return redirect()->route('building-admin.meter_readings.index', $flatId)->with('success', 'Meter reading deleted successfully.');
    }
}
