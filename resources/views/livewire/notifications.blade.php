<div>
    <h3>Your Notifications</h3>
    @if($notifications->isEmpty())
        <p>No notifications.</p>
    @else
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item {{ $notification->read_at ? 'bg-light' : '' }}">
                    {{ $notification->data['message'] }}
                    <a href="{{ $notification->data['link'] }}" class="btn btn-sm btn-primary ml-2">View</a>
                    @if(!$notification->read_at)
                        <button wire:click="markAsRead('{{ $notification->id }}')" class="btn btn-sm btn-secondary ml-2">Mark as Read</button>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>