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
      {{ isset($dismissible) ? 'dismissible' : null }}
      :timer="{{ isset($timer) ? $timer : 10 }}"></alert>
  @endif
@endforeach

{{ session()->forget('flash_notification') }}
