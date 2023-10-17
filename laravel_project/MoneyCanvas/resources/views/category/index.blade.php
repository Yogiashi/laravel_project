<div class="text-center">
    
    <table class="table table-hover text-center">
        <thead><th colspan="3" class="text-white bg-dark rounded">カテゴリ一覧</th></thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td><h4 class="rounded text-white p-1" style="background-color: {{ $category->color }};">{{ $category->name }}</h4></td>
                <td class="text-right">
                    <button type="button" class="btn btn-success" onclick="location.href='/category/edit/{{ $category->id }}'">編集する</button>
                </td>
                <td>
                    <form action="{{ route('categoryDelete', $category->id) }}" method="POST" onSubmit="return checkDelete()">
                    @csrf
                        <button type="submit" class="btn btn-danger">削除する</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    function checkDelete() {
        if(window.confirm('削除してよろしいですか？')) {
            return true;
        } else {
            return false;
        }
    }
</script>