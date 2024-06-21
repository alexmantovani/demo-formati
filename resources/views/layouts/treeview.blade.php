<div class="col-md-auto">
    @foreach ($tree as $group)
    @php
        $step = $loop->index + 1;
    @endphp
        <div class="">
            <h5>
                <a class="nav-link p-0" href="{{ route('goto', $step) }}">
                    Step {{ $step }}
                </a>
            </h5>
        </div>
        @foreach ($group as $item)
            <?php $sperem = $item->first(); ?>
            <div class="">
                <a class="nav-link p-0" style="margin-left: 15px" href="{{ route('goto_group', [$step, $sperem->alias]) }}">
                    {{ $sperem->group_title }}
                </a>
            </div>
        @endforeach
        <div class="pb-3">
        </div>
    @endforeach
</div>
