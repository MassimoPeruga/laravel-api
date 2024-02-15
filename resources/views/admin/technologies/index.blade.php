@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        @include('shared.toast')
        <div class="row">
            <div class="col-12">
                <h2>Tecnologie</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.technologies.create') }}" type="button" class="btn btn-primary mb-3">
                    Aggiungi una nuova tecnologia
                </a>
            </div>
        </div>
        <div class="bg-info-subtle rounded py-3">
            <table class="table table-borderless table-striped table-info align-middle m-0">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="p-2">
                                Nome
                            </span>
                        </th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($technologies as $technology)
                        <tr>
                            <td>
                                <h5 class="m-2">{{ $technology['title'] }}</h5>
                            </td>
                            <td>
                                <div class="text-end p-2">
                                    <a href="{{ route('admin.technologies.show', $technology) }}" type="button"
                                        class="btn btn-info btn-sm">
                                        Progetti associati
                                    </a>
                                    <a href="{{ route('admin.technologies.edit', $technology) }}" type="button"
                                        class="btn btn-warning btn-sm mx-2">
                                        Modifica
                                    </a>
                                    @include('shared.modal', [
                                        'modalClass' => 'btn-sm',
                                        'modalRoute' => 'admin.technologies.destroy',
                                        'itemToDelete' => "$technology[slug]",
                                        'itemName' => "$technology[title]",
                                        'modalWarning' => true,
                                    ])
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
