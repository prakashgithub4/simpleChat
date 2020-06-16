<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script src="{{ asset('js/echo.iife.js') }}"></script>
<script src="{{ asset('js/echo.js') }}"></script>


<script>
Echo.private('pool.{{$pool->id}}')
.listen('EndPool', (e) => {
     alert(e.pool);
});
</script>

<script>
Pusher.logToConsole = true;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '12d9da88c545d19af2c5',
    cluster: 'eu',
    forceTLS: true
});
</script>