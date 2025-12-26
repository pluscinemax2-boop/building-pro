@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Edit Building Information</h2>
    <form method="POST" action="{{ route('building-admin.building-settings.save') }}" class="space-y-6 bg-white dark:bg-[#1a2632] rounded-2xl shadow p-8 border border-gray-100 dark:border-gray-800">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Building Name</label>
                <input type="text" name="building_name" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary" value="{{ old('building_name', $building->name ?? '') }}" required>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Country</label>
                <select name="country" id="country" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary" required>
                    <option value="">Select Country</option>
                    <option value="India" {{ old('country', $building->country ?? '') == 'India' ? 'selected' : '' }}>India</option>
                    <option value="USA" {{ old('country', $building->country ?? '') == 'USA' ? 'selected' : '' }}>USA</option>
                    <option value="Canada" {{ old('country', $building->country ?? '') == 'Canada' ? 'selected' : '' }}>Canada</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">State</label>
                <select name="state" id="state" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary" required>
                    <option value="">Select State</option>
                    <option value="Andhra Pradesh" {{ old('state', $building->state ?? '') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                    <option value="Arunachal Pradesh" {{ old('state', $building->state ?? '') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                    <option value="Assam" {{ old('state', $building->state ?? '') == 'Assam' ? 'selected' : '' }}>Assam</option>
                    <option value="Bihar" {{ old('state', $building->state ?? '') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                    <option value="Chhattisgarh" {{ old('state', $building->state ?? '') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                    <option value="Goa" {{ old('state', $building->state ?? '') == 'Goa' ? 'selected' : '' }}>Goa</option>
                    <option value="Gujarat" {{ old('state', $building->state ?? '') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                    <option value="Haryana" {{ old('state', $building->state ?? '') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                    <option value="Himachal Pradesh" {{ old('state', $building->state ?? '') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                    <option value="Jharkhand" {{ old('state', $building->state ?? '') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                    <option value="Karnataka" {{ old('state', $building->state ?? '') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                    <option value="Kerala" {{ old('state', $building->state ?? '') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                    <option value="Madhya Pradesh" {{ old('state', $building->state ?? '') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                    <option value="Maharashtra" {{ old('state', $building->state ?? '') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                    <option value="Manipur" {{ old('state', $building->state ?? '') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                    <option value="Meghalaya" {{ old('state', $building->state ?? '') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                    <option value="Mizoram" {{ old('state', $building->state ?? '') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                    <option value="Nagaland" {{ old('state', $building->state ?? '') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                    <option value="Odisha" {{ old('state', $building->state ?? '') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                    <option value="Punjab" {{ old('state', $building->state ?? '') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                    <option value="Rajasthan" {{ old('state', $building->state ?? '') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                    <option value="Sikkim" {{ old('state', $building->state ?? '') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                    <option value="Tamil Nadu" {{ old('state', $building->state ?? '') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                    <option value="Telangana" {{ old('state', $building->state ?? '') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                    <option value="Tripura" {{ old('state', $building->state ?? '') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                    <option value="Uttar Pradesh" {{ old('state', $building->state ?? '') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                    <option value="Uttarakhand" {{ old('state', $building->state ?? '') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                    <option value="West Bengal" {{ old('state', $building->state ?? '') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                    <option value="Andaman and Nicobar Islands" {{ old('state', $building->state ?? '') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                    <option value="Chandigarh" {{ old('state', $building->state ?? '') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                    <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('state', $building->state ?? '') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                    <option value="Delhi" {{ old('state', $building->state ?? '') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                    <option value="Jammu and Kashmir" {{ old('state', $building->state ?? '') == 'Jammu and Kashmir' ? 'selected' : '' }}>Jammu and Kashmir</option>
                    <option value="Ladakh" {{ old('state', $building->state ?? '') == 'Ladakh' ? 'selected' : '' }}>Ladakh</option>
                    <option value="Lakshadweep" {{ old('state', $building->state ?? '') == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                    <option value="Puducherry" {{ old('state', $building->state ?? '') == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">City</label>
                <input type="text" name="city" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary" value="{{ old('city', $building->city ?? '') }}">
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Zip Code</label>
                <input type="text" name="zip" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary" value="{{ old('zip', $building->zip ?? '') }}">
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Emergency Phone</label>
                <input type="text" name="emergency_phone" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary" value="{{ old('emergency_phone', $building->emergency_phone ?? '') }}">
            </div>
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Building Address</label>
            <textarea name="building_address" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary" rows="2" required>{{ old('building_address', $building->address ?? '') }}</textarea>
        </div>
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition-all">Save Changes</button>
        </div>
    </form>
</div>
@endsection
