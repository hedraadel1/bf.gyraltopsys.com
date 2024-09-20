<?php

namespace Modules\Cargo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cargo\Entities\Client;
use Modules\Cargo\Entities\Country;
use Modules\Cargo\Entities\SpecialPrice;
use Modules\Cargo\Http\Requests\SpecialPriceRequest;
use Modules\Cargo\Entities\State;
use Modules\Cargo\Entities\Cost;
use Modules\Cargo\Entities\ShipmentSetting;
use Modules\Cargo\Entities\Area;

class SpecialPriceController extends Controller
{

    public function configure(Request $request)
    {
        $data = $request->validate([
            'from_country' => 'required',
            'to_country' => 'required',
            'from_region' => 'nullable',
            'to_region' => 'nullable',
        ]);

        $from = Country::find($data['from_country']);
        $to = Country::find($data['to_country']);
        $from_cities = State::where('country_id', $from->id)->where('covered', 1)->get();
        $to_cities = State::where('country_id', $to->id)->where('covered', 1)->get();

        if (isset($data['from_region']) && isset($data['to_region'])) {
            $from_region = State::where('country_id', $from->id)->where('id', $data['from_region'])->first();
            $to_region = State::where('country_id', $to->id)->where('id', $data['to_region'])->first();
            $from_areas = Area::where('country_id', $from->id)->where('state_id', $data['from_region'])->get();
            $to_areas = Area::where('country_id', $to->id)->where('state_id', $data['to_region'])->get();

            $region_cost = Cost::where(column: 'from_country_id', operator: '=', value: $from->id)
                ->where(column: 'to_country_id', operator: '=', value: $to->id)
                ->where(column: 'from_state_id', operator: '=', value: $from_region->id)
                ->where(column: 'to_state_id', operator: '=', value: $to_region->id)
                ->where(column: 'from_area_id', operator: '=', value: 0)
                ->where(column: 'to_area_id', operator: '=', value: 0)
                ->first();

            if (!isset($region_cost)) {
                $region_cost = new Cost();
                $region_cost->from_country_id = $from->id;
                $region_cost->to_country_id = $to->id;
                $region_cost->from_state_id = $from_region->id;
                $region_cost->to_state_id = $to_region->id;
                $region_cost->save();
            }

            $area_costs = Cost::where(column: 'from_country_id', operator: '=', value: $from->id)
                ->where(column: 'to_country_id', operator: '=', value: $to->id)
                ->where(column: 'from_state_id', operator: '=', value: $from_region->id)
                ->where(column: 'to_state_id', operator: '=', value: $to_region->id)
                ->whereIn('from_area_id', $from_areas->pluck('id')->toArray())
                ->whereIn('to_area_id', $to_areas->pluck('id')->toArray())
                ->get();

            $adminTheme = env('ADMIN_THEME', 'adminLte');
            return view('cargo::' . $adminTheme . '.pages.countries.costs-repeter', compact('from', 'to', 'from_cities', 'to_cities', 'from_region', 'to_region', 'from_areas', 'to_areas', 'region_cost', 'area_costs'));
        } else {
            //  إرجاع  قيمة  في  حالة  عدم  استيفاء  الشرط
            return redirect()->back()->with('error', 'Please select both regions.');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SpecialPrice::query();

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->input(key: 'search');
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Apply other filters as needed (e.g., from_country_id, to_country_id, etc.)

        $specialPrices = $query->with(['client', 'fromCountry', 'fromState', 'fromArea', 'toCountry', 'toState', 'toArea'])->paginate(20);

        return view('cargo::adminLte.pages.shipment-settings.special-prices.index', [
            'specialPrices' => $specialPrices,
            'clients' => Client::all(),
            'countries' => Country::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'from_country' => 'required',
            'to_country' => 'required',
            'from_region' => 'nullable',
            'to_region' => 'nullable',
        ]);

        $from = Country::find($data['from_country']);
        $to = Country::find($data['to_country']);
        $from_cities = State::where('country_id', $from->id)->where('covered', 1)->get();
        $to_cities = State::where('country_id', $to->id)->where('covered', 1)->get();

        if (isset($data['from_region']) && isset($data['to_region'])) {
            $from_region = State::where('country_id', $from->id)->where('id', $data['from_region'])->first();
            $to_region = State::where('country_id', $to->id)->where('id', $data['to_region'])->first();
            $from_areas = Area::where('country_id', $from->id)->where('state_id', $data['from_region'])->get();
            $to_areas = Area::where('country_id', $to->id)->where('state_id', $data['to_region'])->get();

            $region_cost = Cost::where(column: 'from_country_id', operator: '=', value: $from->id)
                ->where(column: 'to_country_id', operator: '=', value: $to->id)
                ->where(column: 'from_state_id', operator: '=', value: $from_region->id)
                ->where(column: 'to_state_id', operator: '=', value: $to_region->id)
                ->where(column: 'from_area_id', operator: '=', value: 0)
                ->where(column: 'to_area_id', operator: '=', value: 0)
                ->first();

            if (!isset($region_cost)) {
                $region_cost = new Cost();
                $region_cost->from_country_id = $from->id;
                $region_cost->to_country_id = $to->id;
                $region_cost->from_state_id = $from_region->id;
                $region_cost->to_state_id = $to_region->id;
                $region_cost->save();
            }

            $area_costs = Cost::where(column: 'from_country_id', operator: '=', value: $from->id)
                ->where(column: 'to_country_id', operator: '=', value: $to->id)
                ->where(column: 'from_state_id', operator: '=', value: $from_region->id)
                ->where(column: 'to_state_id', operator: '=', value: $to_region->id)
                ->whereIn('from_area_id', $from_areas->pluck('id')->toArray())
                ->whereIn('to_area_id', $to_areas->pluck('id')->toArray())
                ->get();

            $adminTheme = env('ADMIN_THEME', 'adminLte');
            return view('cargo::' . $adminTheme . '.pages.countries.costs-repeter', compact('from', 'to', 'from_cities', 'to_cities', 'from_region', 'to_region', 'from_areas', 'to_areas', 'region_cost', 'area_costs'));
        } else {
            //  إرجاع  قيمة  في  حالة  عدم  استيفاء  الشرط
            return redirect()->back()->with('error', 'Please select both regions.');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialPriceRequest $request)
    {
        SpecialPrice::create($request->all());

        return redirect()->route('special-prices.index')->with('success', 'Special price created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\Cargo\Entities\SpecialPrice  $specialPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(SpecialPrice $specialPrice)
    {
        return view('cargo::adminLte.pages.shipment-settings.special-prices.edit', [
            'specialPrice' => $specialPrice,
            'clients' => Client::all(),
            'countries' => Country::all(),
            'fromStates' => State::where('country_id', $specialPrice->from_country_id)->get(),
            'fromAreas' => Area::where('state_id', $specialPrice->from_state_id)->get(),
            'toStates' => State::where('country_id', $specialPrice->to_country_id)->get(),
            'toAreas' => Area::where('state_id', $specialPrice->to_state_id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Cargo\Entities\SpecialPrice  $specialPrice
     * @return \Illuminate\Http\Response
     */
    public function update(SpecialPriceRequest $request, SpecialPrice $specialPrice)
    {
        $specialPrice->update($request->all());

        return redirect()->route('special-prices.index')->with('success', 'Special price updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\Cargo\Entities\SpecialPrice  $specialPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecialPrice $specialPrice)
    {
        $specialPrice->delete();

        return redirect()->route('special-prices.index')->with('success', 'Special price deleted successfully.');
    }
}
