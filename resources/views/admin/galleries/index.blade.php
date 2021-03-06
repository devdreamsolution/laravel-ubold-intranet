@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-image active"></i><span> @lang('global.gallery.title') </span>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.gallery.title')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="row">
            <div class="col-md-4">
                @can('documents_manage')
                <div class="col-md-4 pt-4 pl-4">
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary"><i class="icon-plus"></i> @lang('global.gallery.add') </a>
                </div>
                @endcan
            </div>
            <div class="col-md-8">
                <form action="{{ route('admin.galleries.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-8 pt-4 pl-4">
                            <select name="event" id="event" class="form-control">
                                <option value="0" {{ $event_id == 0 ? 'selected' : '' }}>@lang('global.gallery.select')</option>
                                @foreach ($events as $item)
                                    <option value="{{ $item->id }}" {{ $event_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 pt-4 pl-4 pr-4 text-right">
                            <button class="btn btn-blue" type="submit">
                                <i class="fe-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="responsive-table-plugin">
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dt-responsive table-striped nowrap dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>@lang('dashboard.memo.field.no')</th>
                                    <th>@lang('global.gallery.field.event_name')</th>
                                    <th>@lang('global.gallery.field.title')</th>
                                    <th>@lang('global.gallery.field.gallery')</th>
                                    <th>@lang('dashboard.memo.field.action.title')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($ones as $one)
                                    @if ($one->eventname == null)
                                        @continue
                                    @endif
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        <td>{{ $one->eventname }}</td>
                                        <td>{{ $one->title }}</td>
                                        <td><img src="{{ url('/assets/'.$one->gallery) }}" alt="" height="40px;"></td>
                                        @php $extension = explode('.', $one->gallery) @endphp
                                        <td>
                                            <div class="btn-group mb-2">
                                                @if ($extension[1] == 'pdf')
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/pdf.png" height="30" />
                                                    </a>
                                                @else
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/jpeg.png" height="30" />
                                                    </a>
                                                @endif
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('admin.galleries.show', $one->id) }}"><i class="fe-eye mr-2"></i>@lang('dashboard.memo.field.action.view')</a>
                                                    @can('documents_manage')
                                                        <a class="dropdown-item" href="{{ route('admin.galleries.edit', $one->id) }}"><i class="mdi mdi-square-edit-outline mr-2"></i>@lang('dashboard.memo.field.action.edit')</a>
                                                        <a class="dropdown-item" href="javascript:;" onclick="del({{ $one->id }});"><i class="mdi mdi-delete-outline mr-2"></i>@lang('dashboard.memo.field.action.delete')</a>
                                                    @endcan
                                                </div>
                                            </div>
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
@stop

@section('javascript') 
    <script>
        $(document).ready(function(){
            
        });
        function del(id) {
            swal({
                title: "{{ trans('templates.are you sure?') }}",
                text: "{{ trans('templates.you would not be able to revert this!') }}",
                type: "warning",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-confirm mt-2",
                cancelButtonClass: "btn btn-cancel ml-2 mt-2",
                confirmButtonText: "{{ trans('templates.yes, delete it!') }}",
                cancelButtonText: "{{ trans('templates.cancel') }}",
            }).then(function(e) {
                if (e.value) {
                    $.ajax({
                        url: "{{ url('/admin/galleries/destroy') }}" + "/" + id,
                        type: 'post',
                        dataType: 'text',
                        success: function(data) {
                            window.location="{{ route('admin.galleries.index') }}";
                        }
                    });
                }
            });
        }
    </script>
@endsection
