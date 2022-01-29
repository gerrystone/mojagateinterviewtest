<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="stylesheet" href="{{URL::asset('style.css')}}">
@include('layouts.header')
<body>
<div class="top-nav">
    <div class="container">
        <div class="logo">
            <h5>Mojagate App</h5>
        </div>
    </div>
</div>
@include('layouts.navigation')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <form action="{{route('send_message')}}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h6>Send Message</h6>
                        @include('include.messages')
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Customer</label>
                           <select class="form-control" name="customer">
                               @foreach($customers as $customer)
                                   <option value="{{$customer->id}}">{{$customer->name}}</option>
                               @endforeach
                           </select>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                           <textarea class="form-control" name="message"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <h5> Sent Messages</h5>
            <table class="table table-hover table-stripped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Sent To</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$message->customer->name}}</td>
                        <td>{{$message->customer->phone}}</td>
                        <td>{{$message->message}}</td>
                        <td>{{$message->created_at}}</td>
                        <td>{{$message->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
