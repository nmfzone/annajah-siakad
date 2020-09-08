@foreach (session('flash_notification', collect())->toArray() as $message)
  @if ($message['overlay'])
    @include('flash::modal', [
      'modalClass' => 'flash-modal',
      'title' => $message['title'],
      'body' => $message['message']
    ])
  @else
    <alert
      state="{{ $message['level'] }}"
      message="{{ $message['message'] }}"
      {{ $dismissible ? 'dismissible' : null }}
      timer="{{ $timer ?? '10' }}"></alert>
  @endif
@endforeach

{{ session()->forget('flash_notification') }}
