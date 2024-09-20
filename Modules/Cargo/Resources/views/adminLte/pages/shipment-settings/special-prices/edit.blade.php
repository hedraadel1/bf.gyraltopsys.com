@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    Edit Special Price
@endsection

@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Edit Special Price</h3>
            </div>
        </div>
        <div id="kt_account_profile_details" class="collapse show">
            <form id="kt_account_profile_details_form" class="form" method="POST"
                action="{{ route('special-prices.update', $specialPrice->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body border-top p-9">
                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Client</label>
                        <div class="col-lg-8 fv-row">
                            <select name="client_id" id="client_id" class="form-control form-control-lg form-control-solid"
                                required>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $specialPrice->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">From Location</label>
                        <div class="col-lg-8 fv-row">
                            <div class="row">
                                <div class="col-lg-4 fv-row">
                                    <select name="from_country_id" id="from_country_id"
                                        class="form-control form-control-lg form-control-solid" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ $specialPrice->from_country_id == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 fv-row">
                                    <select name="from_state_id" id="from_state_id"
                                        class="form-control form-control-lg form-control-solid" required>
                                        @foreach ($fromStates as $state)
                                            <option value="{{ $state->id }}"
                                                {{ $specialPrice->from_state_id == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 fv-row">
                                    <select name="from_area_id" id="from_area_id"
                                        class="form-control form-control-lg form-control-solid" required>
                                        @foreach ($fromAreas as $area)
                                            <option value="{{ $area->id }}"
                                                {{ $specialPrice->from_area_id == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">To Location</label>
                        <div class="col-lg-8 fv-row">
                            <div class="row">
                                <div class="col-lg-4 fv-row">
                                    <select name="to_country_id" id="to_country_id"
                                        class="form-control form-control-lg form-control-solid" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ $specialPrice->to_country_id == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 fv-row">
                                    <select name="to_state_id" id="to_state_id"
                                        class="form-control form-control-lg form-control-solid" required>
                                        @foreach ($toStates as $state)
                                            <option value="{{ $state->id }}"
                                                {{ $specialPrice->to_state_id == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 fv-row">
                                    <select name="to_area_id" id="to_area_id"
                                        class="form-control form-control-lg form-control-solid" required>
                                        @foreach ($toAreas as $area)
                                            <option value="{{ $area->id }}"
                                                {{ $specialPrice->to_area_id == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Shipping Cost</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="shipping_cost"
                                class="form-control form-control-lg form-control-solid" placeholder="Shipping cost"
                                value="{{ $specialPrice->shipping_cost }}" required>
                        </div>

                    </div>
                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Return Cost</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="return_cost" class="form-control form-control-lg form-control-solid"
                                placeholder="Return cost" value="{{ $specialPrice->return_cost }}" required>
                        </div>

                    </div>
                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label fw-bold fs-6">Tax</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="tax" class="form-control form-control-lg form-control-solid"
                                placeholder="Tax" value="{{ $specialPrice->tax }}">
                        </div>

                    </div>
                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label fw-bold fs-6">Insurance</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="insurance" class="form-control form-control-lg form-control-solid"
                                placeholder="Insurance" value="{{ $specialPrice->insurance }}">
                        </div>

                    </div>
                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Mile Cost</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="mile_cost" class="form-control form-control-lg form-control-solid"
                                placeholder="Mile cost" value="{{ $specialPrice->mile_cost }}" required>
                        </div>

                    </div>
                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Return Mile Cost</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="return_mile_cost"
                                class="form-control form-control-lg form-control-solid" placeholder="Return mile cost"
                                value="{{ $specialPrice->return_mile_cost }}" required>
                        </div>

                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Discount Type</label>
                        <div class="col-lg-8 fv-row">
                            <select name="discount_type" id="discount_type"
                                class="form-control form-control-lg form-control-solid">
                                <option value="percentage" {{ $specialPrice->discount_percentage ? 'selected' : '' }}>
                                    Percentage</option>
                                <option value="fixed" {{ $specialPrice->discount_fixed_amount ? 'selected' : '' }}>Fixed
                                    Amount</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-6" id="discount_percentage_field"
                        style="{{ $specialPrice->discount_percentage ? '' : 'display:none;' }}">

                        <label class="col-lg-4 col-form-label fw-bold fs-6">Discount Percentage</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="discount_percentage" id="discount_percentage"
                                class="form-control form-control-lg form-control-solid" placeholder="Discount Percentage"
                                value="{{ $specialPrice->discount_percentage }}">
                        </div>

                    </div>

                    <div class="row mb-6" id="discount_fixed_amount_field"
                        style="{{ $specialPrice->discount_fixed_amount ? '' : 'display:none;' }}">

                        <label class="col-lg-4 col-form-label fw-bold fs-6">Fixed Discount Amount</label>
                        <div class="col-lg-8 fv-row">
                            <input type="number" name="discount_fixed_amount" id="discount_fixed_amount"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Fixed Discount Amount" value="{{ $specialPrice->discount_fixed_amount }}">
                        </div>

                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#from_country_id').change(function() {
                var countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: '/get-states/' + countryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#from_state_id').empty();
                            $('#from_state_id').append(
                                '<option value="">Select State</option>');
                            $.each(data, function(key, value) {
                                $('#from_state_id').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            $('#from_state_id').val({
                                {
                                    $specialPrice - > from_state_id
                                }
                            }); // Pre-select the state
                            $('#from_state_id').trigger(
                                'change'); // Trigger change to populate areas
                        }
                    });
                } else {
                    $('#from_state_id').empty();
                    $('#from_area_id').empty();
                }
            });

            $('#from_state_id').change(function() {
                var stateId = $(this).val();
                if (stateId) {
                    $.ajax({
                        url: '/get-areas/' + stateId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#from_area_id').empty();
                            $('#from_area_id').append('<option value="">Select Area</option>');
                            $.each(data, function(key, value) {
                                $('#from_area_id').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            $('#from_area_id').val({
                                {
                                    $specialPrice - > from_area_id
                                }
                            }); // Pre-select the area
                        }
                    });
                } else {
                    $('#from_area_id').empty();
                }
            });

            // Similar AJAX handling for 'to' location fields

            $('#discount_type').change(function() {
                var discountType = $(this).val();
                if (discountType === 'percentage') {
                    $('#discount_percentage_field').show();
                    $('#discount_fixed_amount_field').hide();
                } else {
                    $('#discount_percentage_field').hide();
                    $('#discount_fixed_amount_field').show();
                }
            });

            // Trigger change on page load to show/hide discount fields based on initial value
            $('#discount_type').trigger('change');
        });
    </script>
@endsection
