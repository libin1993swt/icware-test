@extends('layout')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Event {{ $event->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('events-list') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $event->id }}</td>
                                    </tr>
                                    <tr><th> Event Name </th><td> {{ $event->name }} </td></tr><tr><th> Start Date </th><td> {{ date('d-m-Y',strtotime($event->start_date)) }} </td></tr><tr><th> End Date </th><td> {{ date('d-m-Y',strtotime($event->end_date)) }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
