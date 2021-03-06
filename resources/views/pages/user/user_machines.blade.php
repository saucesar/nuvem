@extends('layouts.app', ['activePage' => 'user-machines', 'titlePage' => __("User's Machines")])

@section('content')
<div class="content" style="zoom: 85%;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Machines Table</h4>
            <p class="card-category">List of {{ $user_name }}' machines</p>
          </div>
          <div class="card-body">
            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @include('pages/tables/machine_table', ['machines' => $machines])
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-11 text-right" style="margin-left: 48px;">
    <button class="btn btn-primary btn-fab btn-round" data-toggle="modal" data-target="#machineModal">
        <i class="material-icons" style="color:white">add_to_queue</i>
      </a>
      @include('pages.components.messages')
    </button>
  </div>
  @include('pages.user.machines_modal')
  @foreach ($machines as $machine)
    @include('pages.user.machines_modal', ['machine' => $machine])
  @endforeach
</div>
@endsection
