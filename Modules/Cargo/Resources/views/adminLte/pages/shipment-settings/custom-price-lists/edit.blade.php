@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    {{ __('cargo::view.edit_custom_price_list') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('cargo::view.edit_custom_price_list') }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('custom-price-lists.update', $customPriceList->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">{{ __('cargo::view.name') }}:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customPriceList->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="discount_type">{{ __('cargo::view.discount_type') }}:</label>
                            <select name="discount_type" id="discount_type" class="form-control">
                                <option value="">{{ __('cargo::view.none') }}</option>
                                <option value="percentage" {{ old('discount_type', $customPriceList->discount_type) == 'percentage' ? 'selected' : '' }}>{{ __('cargo::view.percentage') }}</option>
                                <option value="fixed" {{ old('discount_type', $customPriceList->discount_type) == 'fixed' ? 'selected' : '' }}>{{ __('cargo::view.fixed_amount') }}</option>
                            </select>
                        </div>

                        <div class="form-group" id="discount_value_container" style="{{ old('discount_type', $customPriceList->discount_type) ? '' : 'display: none;' }}">
                            <label for="discount_value">{{ __('cargo::view.discount_value') }}:</label>
                            <input type="number" name="discount_value" id="discount_value" class="form-control" value="{{ old('discount_value', $customPriceList->discount_value) }}" min="0">
                        </div>

                        <hr>

                        <table class="table table-bordered" id="areasTable">
                            <thead>
                                <tr>
                                    <th>{{ __('cargo::view.from_country') }}</th>
                                    <th>{{ __('cargo::view.from_state') }}</th>
                                    <th>{{ __('cargo::view.from_area') }}</th>
                                    <th>{{ __('cargo::view.to_country') }}</th>
                                    <th>{{ __('cargo::view.to_state') }}</th>
                                    <th>{{ __('cargo::view.to_area') }}</th>
                                    <th>{{ __('cargo::view.shipping_cost') }}</th>
                                    <th>{{ __('cargo::view.return_cost') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($countries as $fromCountry)
                                    @foreach ($fromCountry->states as $fromState)
                                        @foreach ($fromState->areas as $fromArea)
                                            @foreach ($countries as $toCountry)
                                                @foreach ($toCountry->states as $toState)
                                                    @foreach ($toState->areas as $toArea)
                                                        <tr>
                                                            <td>
                                                                {{ $fromCountry->name }}
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][from_country_id]" value="{{ $fromCountry->id }}">
                                                            </td>
                                                            <td>
                                                                {{ $fromState->name }}
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][from_state_id]" value="{{ $fromState->id }}">
                                                            </td>
                                                            <td>
                                                                {{ $fromArea->name }}
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][from_area_id]" value="{{ $fromArea->id }}">
                                                            </td>
                                                            <td>
                                                                {{ $toCountry->name }}
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][to_country_id]" value="{{ $toCountry->id }}">
                                                            </td>
                                                            <td>
                                                                {{ $toState->name }}
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][to_state_id]" value="{{ $toState->id }}">
                                                            </td>
                                                            <td>
                                                                {{ $toArea->name }}
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][to_area_id]" value="{{ $toArea->id }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][shipping_cost]" class="form-control shipping_cost" value="{{ $customPriceList->areas->where('from_area_id', $fromArea->id)->where('to_area_id', $toArea->id)->first()->shipping_cost ?? ($fromArea->costs->where('to_area_id', $toArea->id)->first()->shipping_cost ?? 0) }}" min="0" step="0.01" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][return_cost]" class="form-control return_cost" value="{{ $customPriceList->areas->where('from_area_id', $fromArea->id)->where('to_area_id', $toArea->id)->first()->return_cost ?? ($fromArea->costs->where('to_area_id', $toArea->id)->first()->return_cost ?? 0) }}" min="0" step="0.01" required>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary mt-3">{{ __('cargo::view.update_price_list') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Show/hide discount value input based on discount type selection
        $('#discount_type').change(function() {
            if ($(this).val() !== '') {
                $('#discount_value_container').show();
            } else {
                $('#discount_value_container').hide();
            }
        });
    });
</script>
@endsection