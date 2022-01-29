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
              <form action="{{route('add_customer')}}" method="post">
                  @csrf
                  <div class="card">
                      <div class="card-header">
                          <h6>Add Customer</h6>
                          @include('include.messages')
                      </div>
                      <div class="card-body">
                          <div class="form-group">
                              <label>Full Name</label>
                              <input type="text" name="name" class="form-control" value="{{old('name')}}">
                          </div>
                          <div class="form-group">
                              <label>Phone Number</label>
                              <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
                          </div>
                          <div class="form-group">
                              <label>Email</label>
                              <input type="email" name="email" class="form-control" value="{{old('email')}}">
                          </div>
                          <div class="form-group">
                              <label>Town</label>
                              <input type="text" name="town" class="form-control" value="{{old('town')}}">
                          </div>
                      </div>
                      <div class="card-footer">
                          <button class="btn btn-success">Add Customer</button>
                      </div>
                  </div>
              </form>
          </div>
          <div class="col-md-8">
              <h5> List of Customers</h5>
              <table class="table table-hover table-stripped">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Town</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $customer)
                       <tr>
                           <td>{{$loop->index+1}}</td>
                           <td>{{$customer->name}}</td>
                           <td>{{$customer->phone}}</td>
                           <td>{{$customer->email}}</td>
                           <td>{{$customer->town}}</td>
                       </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  </body>
</html>
