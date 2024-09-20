
@extends('cargo::adminLte.layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Special Prices</div>

                    <div class="card-body">
                        {{-- Search & Filter Options --}}
                        <form method="GET" action="{{ route('special-prices.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Search by Client Name" value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="from_country_id" class="form-control">
                                        <option value="">All Countries</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ request('from_country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Add more filter options as needed --}}
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                                
                                <div class="text-right mb-3">
    <a href="{{ route('special-prices.create') }}" class="btn btn-primary">
        {{ __('cargo::view.add_new_price_list') }}
    </a>
</div>
                            </div>
                        </form>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>From Country</th>
                                    <th>From State</th>
                                    <th>From Area</th>
                                    <th>To Country</th>
                                    <th>To State</th>
                                    <th>To Area</th>
                                    <th>Shipping Cost</th>
                                    <th>Return Cost</th>
                                    {{-- Add other cost columns as needed --}}
                                    <th>Discount %</th>
                                    <th>Fixed Discount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($specialPrices as $specialPrice)
                                    <tr>
                                        <td>{{ $specialPrice->client->name }}</td>
                                        <td>{{ $specialPrice->fromCountry->name }}</td>
                                        <td>{{ $specialPrice->fromState->name }}</td>
                                        <td>{{ $specialPrice->fromArea->name }}</td>
                                        <td>{{ $specialPrice->toCountry->name }}</td>
                                        <td>{{ $specialPrice->toState->name }}</td>
                                        <td>{{ $specialPrice->toArea->name }}</td>
                                        <td>{{ $specialPrice->shipping_cost }}</td>
                                        <td>{{ $specialPrice->return_cost }}</td>
                                        {{-- Add other cost values as needed --}}
                                        <td>{{ $specialPrice->discount_percentage }}</td>
                                        <td>{{ $specialPrice->discount_fixed_amount }}</td>
                                        <td>
                                            <a href="{{ route('special-prices.edit', $specialPrice->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('special-prices.destroy', $specialPrice->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $specialPrices->links() }} {{-- Pagination links --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection