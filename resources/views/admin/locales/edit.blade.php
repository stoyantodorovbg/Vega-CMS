@extends('admin.layouts.app')

@section('content')
    <div class="row pr-4 pt-2">
        <div class="col-12 mb-3">
            <button-link :prop_data="{
                'url': '{{ route('admin-locales.index') }}',
                'text': '{{ phrase('buttons.all-locales') }}',
                'htmlClass': 'btn btn-main float-right m-1 text-capitalize'
            }"
            ></button-link>
            <button-link :prop_data="{
                'url': '{{ route('admin-locales.show', $locale->getSlug()) }}',
                'text': '{{ phrase('buttons.show-locale') }}',
                'htmlClass': 'btn btn-danger float-right m-1 text-capitalize'
            }"
            ></button-link>
        </div>
        <div class="col-12 pr-3">
            @include('admin.locales._form')
        </div>
    </div>
@endsection
