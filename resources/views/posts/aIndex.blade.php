
<x-adminlayout>
        
    <h1 class="title">MACLAB SCHEDULES</h1>

    <div class="grid grid-cols-2 gap-6">

        @foreach ($posts as $post)
            <x-postCard :post="$post"/>
        @endforeach

    </div>

    <div>
        {{ $posts->links() }}
    </div>

</x-adminlayout>
