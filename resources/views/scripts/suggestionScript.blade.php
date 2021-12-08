<script type="text/javascript">
    let isAccepted = confirm("не хотите оставить отзыв о нашем сайте?");
    if (isAccepted)
    {
        let url = new URL("{{ route('appeal') }}");
        url.searchParams.append('accepted', '1');
        window.location.href = url;
    }
</script>
