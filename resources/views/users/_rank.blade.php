@if (count($rank) >0)

    <table id="table" data-toggle="table" class="table table-striped">
        <thead>
        <tr>
            <th>玩家id</th>
            <th>玩家姓名</th>
            <th>游戏记录id</th>
            <th>玩家角色</th>
            <th>角色类型</th>
            <th>对局得分</th>
            <th>对局结果</th>
            <th>所属赛季</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($rank as $item)
            <tr>
                <td>{{$item->player_id}}</td>
                <td>{{$item->player->player}}</td>
                <td>{{$item->record_id}}</td>
                <td>{{$item->player_role}}</td>
                <td>{{$item->role_type}}</td>
                <td>{{$item->score}}</td>
                <td>
                    @if ($item->score > 0)
                        <span style="color: green;">胜利</span>
                    @elseif ($item->score == 0)
                        <span style="color: red;">失败</span>
                    @else
                        错误
                    @endif
                </td>
                <td>S{{$item->season}}赛季</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@else
    <div class="empty-block" style="margin:20px 0 0 15px">暂无数据 ~_~</div>
@endif

{{-- 分页 --}}
<div class="mt-4 pt-1">
    {!! $rank->appends(Request::except('page'))->render() !!}
</div>
