@extends('layouts.app', ['activePage' => 'docker-swarm', 'titlePage' => __("Docker Swarm"), 'title' => __("DockerSwarm")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Docker Swarm</h4>
                            <p class="card-category">Your Nodes</p>
                        </div>
                        <div class="card-body">
                            @if(isset($error))
                            <div class="alert alert-danger">{{ $error }}</div>
                            @elseif(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @elseif(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($swarm)
                            <h3>Manager Info</h3>
                            <table class="table table-bordered">
                                <thead class="">
                                    <th>ID</th>
                                    <th>Hostname</th>
                                    <th>Plataform</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">{{ $swarm['ID'] }}</td>
                                        <td scope="col">{{ $nodes[0]['Description']['Hostname']  }}</td>
                                        <td scope="col">
                                            {{ $nodes[0]['Description']['Platform']['OS'].'_'.$nodes[0]['Description']['Platform']['Architecture'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead class="">
                                    <th>IP</th>
                                    <th>Reachability</th>
                                    <th>State</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">{{ $nodes[0]['ManagerStatus']['Addr'] }}</td>
                                        <td scope="col">{{ $nodes[0]['ManagerStatus']['Reachability'] }}</td>
                                        <td scope="col">{{ $nodes[0]['Status']['State'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <table class="table table-bordered">
                                <thead class="">
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>DataPathPort</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">{{ $swarm['CreatedAt'] }}</td>
                                        <td scope="col">{{ $swarm['UpdatedAt'] }}</td>
                                        <td scope="col">{{ $swarm['DataPathPort'] }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead class="">
                                    <th>To join in this swarm as worker run</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">
                                            <small><b>docker swarm join --token={{ $swarm['JoinTokens']['Worker'].' '.$nodes[0]['ManagerStatus']['Addr'] }}</b></small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead class="">
                                    <th>To join in this swarm as manager run</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col">
                                            <small><b>docker swarm join --token={{ $swarm['JoinTokens']['Manager'].' '.$nodes[0]['ManagerStatus']['Addr'] }}</b></small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <h3>Nodes</h3>

                            <table class="table table-bordered">
                                <thead class="">
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Availability</th>
                                    <th>Plataform</th>
                                    <th>Hostname</th>
                                    <th>Memory</th>
                                    <th>Status</th>
                                    <th>Addr</th>
                                    <th>EngineVersion</th>
                                </thead>
                                <tbody>
                                @foreach($nodes as $node)
                                    <tr>
                                        <td scope="col">{{ $node['ID'] }}</td>
                                        <td scope="col">{{ $node['Spec']['Role'] }}</td>
                                        <td scope="col">{{ $node['Spec']['Availability'] }}</td>
                                        <td scope="col">{{ $node['Description']['Platform']['OS'].'_'.$node['Description']['Platform']['Architecture'] }}</td>
                                        <td scope="col">{{ $node['Description']['Hostname'] }}</td>
                                        <td scope="col">{{ round($node['Description']['Resources']['MemoryBytes']/pow(1024, 3), 2) }} GB</td>
                                        <td scope="col">{{ $node['Status']['State'] }}</td>
                                        <td scope="col">{{ $node['Status']['Addr'] }}</td>
                                        <td scope="col">{{ $node['Description']['Engine']['EngineVersion'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <h3>Services</h3>

                            <table class="table table-bordered">
                                <thead class="">
                                    <th></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="col"></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <form action="{{ route('docker-swarm.leave') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('are you sure?q')">
                                    <i class="fas fa-sign-out-alt"> Leave to a Swarm </i>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('docker-swarm.init') }}" method="post">
                                @csrf
                                <input type="text" class="form-control" name="ip" value=""
                                    placeholder="enter the ip or leave it blank to try to get it automatically.">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus-circle"> Initialize a Swarm </i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection