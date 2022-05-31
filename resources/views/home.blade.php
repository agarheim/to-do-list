@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
            <div class="card">
            <form method="POST" action="{{ route('task/add') }}" class="fn_addTask">
                @csrf

                <div class="form-group row">
                    <label for="descriptionTask" class="col-md-4 col-form-label text-md-right">{{ __('Description Task') }}</label>

                    <div class="col-md-6">
                        <input id="descriptionTask" type="text" class="form-control @error('descriptionTask') is-invalid @enderror" name="descriptionTask" value="{{ old('descriptionTask') }}" required autocomplete="descriptionTask" autofocus>

                        @error('descriptionTask')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
            </form>
            </div>
            <div class="card" >
                <table class="table" id="fn_desk_to_task">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('mytranslation.Name_Task') }}</th>
                        <th scope="col">{{ __('mytranslation.Apply_to_work') }}</th>
                        <th scope="col">{{ __('mytranslation.Delete_Task') }}</th>
                    </tr>
                    </thead>
                    <tbody id="fn_task_desc">
                    @foreach($taskItems as $item)
                        <tr class="@if($item->status=='new') bg-light @elseif($item->status=='to_work') bg-info  @elseif($item->status=='finished') bg-success @else bg-danger @endif" id="{{ $item->id }}" data-id="{{ $item->id }}">
                            <th scope="row">{{ $item->id }}</th>
                            <td >{{ $item->name_task }}</td>
                            <td data-name="@if($item->status=='new') to_work @elseif($item->status=='to_work') finished @endif" class="to-work">
                                <i class="fas fa-safari" aria-hidden="true" data-name="@if($item->status=='new') to_work @elseif($item->status=='to_work') finished @endif">
                                    @if($item->status=='new') to_work @elseif($item->status=='to_work') to finish @elseif($item->status=='finished') ok @endif</i></td>
                            <td data-name="archive" class="to-delete"><i class="far fa-trash" aria-hidden="true" data-name="archive" >to trash</i></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
