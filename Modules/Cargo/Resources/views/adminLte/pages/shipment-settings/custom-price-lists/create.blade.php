@extends('cargo::adminLte.layouts.master')  
  
@section('pageTitle')  
    انشاء قائمة اسعار جديدة
@endsection  
  
@section('content')  
<div class="container-fluid">  
    <div class="row">  
        <div class="col-12">  
            <div class="card">  
                <div class="card-header">  
                    <h3 class="card-title">انشاء قائمة اسعار جديدة</h3>  
                </div>  
  
                <div class="card-body">  
                    <form action="{{ route('custom-price-lists.store') }}" method="POST">  
                        @csrf  
                        <div class="form-group">  
                            <label for="name">اسم قائمة الاسعار</label>  
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>  
                        </div>  
                        <div class="form-group">  
                            <label for="discount_type">نوع الخصم : </label>  
                            <select name="discount_type" id="discount_type" class="form-control">  
                                <option value="">لا يوجد خصم</option>  
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>نسبة مئوية</option>  
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>قيمة ثابتة</option>  
                            </select>  
                        </div>  
                        <div class="form-group" id="discount_value_container" style="{{ old('discount_type') ? '' : 'display: none;' }}">  
                            <label for="discount_value">قيمة الخصم</label>  
                            <input type="number" name="discount_value" id="discount_value" class="form-control" value="{{ old('discount_value') }}" min="0">  
                        </div>  
                        <hr>  
                        <table class="table table-bordered" id="areasTable">  
                            <thead>  
                                <tr>  
                                    <th style="display:none">{{ __('cargo::view.from_country') }}</th>  
                                    <th style="display:none">من محافظة</th>  
                                    <th>من منطقة</th>  
                                    <th style="display:none">{{ __('cargo::view.to_country') }}</th>  
                                    <th style="display:none">الى محافظة</th>  
                                    <th>الى منطقة</th>  
                                    <th>قيمة الشحن</th>  
                                    <th>قيمة المرتجع</th>  
                                </tr>  
                            </thead>  
                            <tbody>  
                                @foreach ($countries as $fromCountry)  
                                    @foreach ($fromCountry->states as $fromState)  
                                        @foreach ($fromState->areas as $fromArea)  
                                            @foreach ($countries as $toCountry)  
                                                @foreach ($toCountry->states as $toState)  
                                                    @foreach ($toState->areas as $toArea)  
                                                        @php  
                                                            $cost = optional($fromArea->costs ?? collect())->where('to_area_id', $toArea->id)->first() ?? (object) ['shipping_cost' => 0, 'return_cost' => 0];  
                                                        @endphp  
                                                        <tr>  
                                                            <td style="display:none">  
                                                                {{ $fromCountry->name }}  
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][from_country_id]" value="{{ $fromCountry->id }}">  
                                                            </td>  
                                                            <td style="display:none">  
                                                                {{ $fromState->name }}  
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][from_state_id]" value="{{ $fromState->id }}">  
                                                            </td>  
                                                            <td>  
                                                               
                                                                <input disabled readonly class="form-control disabled" value="{{json_decode($fromArea->name, true)[app()->getLocale()]}}">
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][from_area_id]" value="{{ $fromArea->id }}">  
                                                            </td>  
                                                            <td style="display:none">  
                                                                {{ $toCountry->name }}  
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][to_country_id]" value="{{ $toCountry->id }}">  
                                                            </td>  
                                                            <td style="display:none">  
                                                                {{ $toState->name }}  
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][to_state_id]" value="{{ $toState->id }}">  
                                                            </td>  
                                                            <td>  
                                                                
                                                                <input disabled readonly class="form-control disabled" value="{{json_decode($toArea->name, true)[app()->getLocale()]}}">
                                                                <input type="hidden" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][to_area_id]" value="to_area_id">  
                                                            </td>  
                                                            <td>  
                                                                <input  type="number" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][shipping_cost]" class="form-control shipping_cost" value="{{ $cost->shipping_cost }}" min="0" step="0.01" required>  
                                                            </td>  
                                                            <td>  
                                                                <input type="number" name="areas[{{ $fromArea->id }}-{{ $toArea->id }}][return_cost]" class="form-control return_cost" value="{{ $cost->return_cost }}" min="0" step="0.01" required>  
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
                        <button type="submit" class="btn btn-primary mt-3">{{ __('cargo::view.create_price_list') }}</button>  
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
