<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->get();

        return view('customer.profile.index', compact('addresses'));
    }

    public function create()
    {
        return view('customer.profile.address-form', [
            'address' => null,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateAddress($request);
        $validated['user_id'] = Auth::id();
        $validated['is_default'] = $request->has('is_default');

        if ($request->has('is_default')) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        Address::create($validated);

        return redirect()->route('customer.profile.index')->with('success', 'Alamat berhasil ditambahkan');
    }

    public function show(int $id)
    {
        $address = $this->getUserAddress($id);

        return view('customer.profile.address-form', [
            'address' => $address,
            'mode' => 'show',
        ]);
    }

    public function edit(int $id)
    {
        $address = $this->getUserAddress($id);

        return view('customer.profile.address-form', [
            'address' => $address,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, int $id)
    {
        $address = $this->getUserAddress($id);
        $validated = $this->validateAddress($request);
        $validated['is_default'] = $request->has('is_default');

        // Reset default jika checkbox di-check
        if ($request->has('is_default')) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('customer.profile.index')->with('success', 'Alamat berhasil diperbarui');
    }


    public function destroy(int $id)
    {
        $address = $this->getUserAddress($id);

        $address->delete();

        return redirect()->route('customer.profile.index')->with('success', 'Alamat berhasil dihapus');
    }

    private function validateAddress(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'raja_ongkir_id' => 'required|integer',
            'subdistrict_name' => 'required|string|max:100',
            'district_name' => 'required|string|max:100',
            'city_name' => 'required|string|max:100',
            'province_name' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
        ]);
    }

    private function getUserAddress(int $id): Address
    {
        $address = Address::findOrFail($id);

        if ($address->user_id !== Auth::id()) {
            abort(403, 'Alamat Tidak valid');
        }

        return $address;
    }
}
