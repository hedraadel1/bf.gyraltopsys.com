<?php

namespace Modules\Cargo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cargo\Entities\Client;
use Modules\Cargo\Entities\Country;
use Modules\Cargo\Entities\State;
use Modules\Cargo\Entities\Area;
use Modules\Cargo\Entities\Cost;
use Modules\Cargo\Entities\CustomPriceList;
use Modules\Cargo\Entities\CustomPriceListArea;
use Modules\Cargo\Http\Requests\CustomPriceListRequest;

class CustomPriceListController extends Controller
{
    public function index()
    {
        $priceLists = CustomPriceList::with('clients')->get();
        return view('cargo::adminLte.pages.shipment-settings.custom-price-lists.index', compact('priceLists'));
    }

    public function create()
    {
        $countries = Country::where('covered', 1)->with('states.areas')->get();
        return view('cargo::adminLte.pages.shipment-settings.custom-price-lists.create', compact('countries'));
    }

    public function store(CustomPriceListRequest $request)
    {
        $validatedData = $request->validated();

        // Create the custom price list
        $priceList = CustomPriceList::create($validatedData);

        // Create the custom price list areas
        foreach ($validatedData['areas'] as $areaData) {
            CustomPriceListArea::create([
                'custom_price_list_id' => $priceList->id,
                'from_country_id' => $areaData['from_country_id'],
                'from_state_id' => $areaData['from_state_id'],
                'from_area_id' => $areaData['from_area_id'],
                'to_country_id' => $areaData['to_country_id'],
                'to_state_id' => $areaData['to_state_id'],
                'to_area_id' => $areaData['to_area_id'],
                'shipping_cost' => $areaData['shipping_cost'],
                'return_cost' => $areaData['return_cost'],
            ]);
        }

        return redirect()->route('custom-price-lists.index')->with('success', 'Custom price list created successfully!');
    }

    public function edit(CustomPriceList $customPriceList)
    {
        $countries = Country::where('covered', 1)->with('states.areas')->get();
        return view('cargo::adminLte.pages.shipment-settings.custom-price-lists.edit', compact('customPriceList', 'countries'));
    }

    public function update(CustomPriceListRequest $request, CustomPriceList $customPriceList)
    {
        $validatedData = $request->validated();

        // Update the custom price list
        $customPriceList->update($validatedData);

        // Update or create the custom price list areas
        foreach ($validatedData['areas'] as $areaData) {
            $customPriceList->areas()->updateOrCreate([
                'from_country_id' => $areaData['from_country_id'],
                'from_state_id' => $areaData['from_state_id'],
                'from_area_id' => $areaData['from_area_id'],
                'to_country_id' => $areaData['to_country_id'],
                'to_state_id' => $areaData['to_state_id'],
                'to_area_id' => $areaData['to_area_id'],
            ], [
                'shipping_cost' => $areaData['shipping_cost'],
                'return_cost' => $areaData['return_cost'],
            ]);
        }

        return redirect()->route('custom-price-lists.index')->with('success', 'Custom price list updated successfully!');
    }

    public function destroy(CustomPriceList $customPriceList)
    {
        $customPriceList->delete();

        return redirect()->route('custom-price-lists.index')->with('success', 'Custom price list deleted successfully!');
    }
}