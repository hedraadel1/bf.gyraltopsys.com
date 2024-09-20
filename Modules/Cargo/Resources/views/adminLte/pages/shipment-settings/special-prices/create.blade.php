@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    Create Special Price
@endsection

@section('content')

    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Create Special Price</h3>
            </div>
        </div>
        <div id="kt_account_profile_details" class="collapse show">
            <form id="kt_account_profile_details_form" class="form" method="GET" action="{{ route('special-prices.configure') }}">
                @csrf
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Client</label>
                        <div class="col-lg-8 fv-row">
                            <select name="client_id" id="client_id" class="form-control form-control-lg form-control-solid" required>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">From Country</label>
                        <div class="col-lg-8 fv-row">
                            <select name="from_country" id="from_country" class="form-control form-control-lg form-control-solid" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">To Country</label>
                        <div class="col-lg-8 fv-row">
                            <select name="to_country" id="to_country" class="form-control form-control-lg form-control-solid" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Next</button>
                </div>
            </form>
        </div>
    </div>

@endsection
