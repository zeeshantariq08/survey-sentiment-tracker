<div class="p-4">
    @foreach($this->getData()['words'] as $word => $count)
        <span class="text-lg font-bold m-1" style="font-size: {{ 12 + ($count * 2) }}px;">{{ $word }}</span>
    @endforeach
</div>