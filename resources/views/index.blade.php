@extends('layout.default')
@section('content')
    <h1 class="text-center">
        Bad Broker Test Task
    </h1>
    <div class="card mx-auto" style="width: 50rem;">
        <div class="card-body">
            <form class="js-ajax-form" action="/api/get_maximum_revenue">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Start date</label>
                    <input type="date" name="startDate" class="form-control" id="startDate"
                        aria-describedby="startDateHelp">
                    <div id="startDateHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">End date</label>
                    <input type="date" name="endDate" class="form-control" id="endDate" aria-describedby="endDateHelp">
                    <div id="endDateHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Amount</label>
                    <input type="number" name="amount" step="0.01" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
