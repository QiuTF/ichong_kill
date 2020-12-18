@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link bg-transparent {{ Request::query('season') == 1 ? 'active':'' }}"
                       href="{{ Request::url() }}?season=1">
                        S1 赛季
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link bg-transparent {{ Request::query('season') != 1 ? 'active':'' }}"
                       href="{{ Request::url() }}?season=2">
                        S2 赛季
                    </a>
                </li>
            </ul>
            <table id="table" data-toggle="table" class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>玩家姓名</th>
                    <th>玩家总得分</th>
                    <th>胜场</th>
                    <th>负场</th>
                    <th>胜率</th>
                    <th>mvp次数</th>
                    <th>连续战绩</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($rank as $item)
                    <tr>
                        <td>{{$item->player_id}}</td>
                        <td>
                            <a href="{{ route('users.show', [$item->player_id]) }}" title="{{ $item->player }}">
                                {{$item->player}}
                            </a>
                        </td>
                        <td>{{$item->score}}</td>
                        <td>{{$item->wins}}</td>
                        <td>{{$item->fail}}</td>
                        <td>{{$item->rate}}%</td>
                        <td>{{$item->mvp}}</td>
                        <td>
                            @if ($item->countsnum->wins > 0)
                                <span style="color: green;">{{$item->countsnum->wins}} 连胜</span>
                            @elseif ($item->countsnum->fails > 0)
                                <span style="color: red;">{{$item->countsnum->fails}} 连败</span>
                            @else
                                无游戏记录
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
