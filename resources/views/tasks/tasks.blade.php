<ul class="list-unstyled">
    <h1>タスク一覧</h1>
        @if (count($tasks) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>ステータス</th>
                        <th>タスク内容</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>{!! link_to_route('tasks.show',$task->id, ['id' => $task->id]) !!}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ $task->content }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </ul>
{{ $tasks->links('pagination::bootstrap-4') }}