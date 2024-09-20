@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    {{ __('cargo::view.custom_price_lists') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('cargo::view.custom_price_lists') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('custom-price-lists.create') }}" class="btn btn-primary btn-sm">
                            {{ __('cargo::view.add_new_price_list') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('cargo::view.id') }}</th>
                                <th>{{ __('cargo::view.name') }}</th>
                                <th>{{ __('cargo::view.discount') }}</th>
                                <th>{{ __('cargo::view.clients') }}</th>
                                <th>{{ __('cargo::view.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($priceLists as $priceList)
                                <tr>
                                    <td>{{ $priceList->id }}</td>
                                    <td>{{ $priceList->name }}</td>
                                    <td>
                                        @if ($priceList->discount_type == 'percentage')
                                            {{ $priceList->discount_value }}%
                                        @elseif ($priceList->discount_type == 'fixed')
                                            {{ $priceList->discount_value }} {{ __('cargo::view.currency') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($priceList->clients->count() > 0)
                                            <ul>
                                                @foreach ($priceList->clients as $client)
                                                    <li>{{ $client->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('custom-price-lists.edit', $priceList->id) }}" class="btn btn-primary btn-sm">
                                            {{ __('cargo::view.edit') }}
                                        </a>
                                        <form action="{{ route('custom-price-lists.destroy', $priceList->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('cargo::view.are_you_sure_you_want_to_delete_this_price_list') }}?')">
                                                {{ __('cargo::view.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection